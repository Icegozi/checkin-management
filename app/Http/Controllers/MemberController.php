<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Qrcode;
use BaconQrCode\Common\ErrorCorrectionLevel;
use Endroid\QrCode\Builder\Builder;
use Exception;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with(['qrcodes', 'users'])->paginate(6);
        
        return view('staff.pages.member.index', compact('members'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.pages.member.create');
    }

    public function getProvinces()
    {
        $provinces = DB::select('SELECT code, full_name FROM provinces');
        return response()->json($provinces);
    }

    public function getDistrictsByProvinceCode($provinceCode)
    {
        $districts = DB::select('SELECT code, full_name FROM districts WHERE province_code = ?', [$provinceCode]);
        return response()->json($districts);
    }

    public function getWardsByDistrictCode($districtCode)
    {
        $wards = DB::select('SELECT code, full_name FROM wards WHERE district_code = ?', [$districtCode]);
        return response()->json($wards);
    }

    public function extendMembers(Request $request)
    {
        $memberIds = $request->input('member_ids');
        $extendValue = $request->input('extend_value');
        if (empty($memberIds) || !$extendValue) {
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        }
        $monthsToExtend = (int)$extendValue;
        try {
            foreach ($memberIds as $memberId) {
                $qrcode = Qrcode::where('member_id', $memberId)->first();
                if ($qrcode) {
                    $currentTime = \Carbon\Carbon::now();
                    $expriedTime = \Carbon\Carbon::parse($qrcode->expried_time);
                    if ($expriedTime->lessThan($currentTime)) {
                        $newExpiry = $currentTime->addMonths($monthsToExtend);
                    } else {
                        $newExpiry = $expriedTime->addMonths($monthsToExtend);
                    }
                    $qrcode->expried_time = $newExpiry;
                    $qrcode->save();
                }
            }            
            return response()->json(['success' => true, 'message' => 'Gia hạn thành công.']);
        } catch (Exception $e) {
            Log::error('Lỗi gia hạn thành viên: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi khi xử lý dữ liệu.']);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|integer',
            'address_detail' => 'required|string|max:255',
            'membership_fee' => 'nullable|numeric|max:9999999.99',
            'phone_number' => 'required|string|max:15|unique:members,phone_number',
            'email' => 'required|email|max:255|unique:members,email',
            'contact' => 'required|integer',
            'photoUse' => 'required|integer',
            'note' => 'nullable|string',
            'expried_time' => [
                'required',
                'date',
                'after_or_equal:' . now()->format('Y-m-d H:i:s'),
            ], 
        ], [
            'fullname.required' => 'Họ và tên không được để trống.',
            'fullname.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'birthday.required' => 'Ngày sinh không được để trống.',
            'birthday.date' => 'Ngày sinh phải là một ngày hợp lệ.',
            'gender.required' => 'Giới tính không được để trống.',
            'address_detail.required' => 'Địa chỉ không được để trống.',
            'membership_fee.numeric' => 'Phí thành viên phải là số.',
            'phone_number.required' => 'Số điện thoại không được để trống.',
            'phone_number.unique' => 'Số điện thoại đã được sử dụng.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'expried_time.required' => 'Thời gian hiệu lực không được để trống.',
            'expried_time.date' => 'Thời gian hiệu lực phải là một ngày hợp lệ.',
            'expried_time.after_or_equal' => 'Thời gian hiệu lực phải là ngày sau hoặc bằng :date.',
        ]);

        $address = trim($request->address_detail) . ', ' . $this->getFullNameWard($request->ward) . ', ' . $this->getFullNamedistricts($request->district) . ', '. $this->getFullNameCity($request->city);

        DB::beginTransaction();
        try {
            // 1. Tạo member
            $member = new Member();
            $member->user_id = trim($request->user_id);
            $member->fullname = trim(ucwords(strtolower($request->fullname)));
            $member->nickname = trim($request->nickname);
            $member->birthday = $request->birthday;
            $member->membership_fee = trim($request->membership_fee);
            $member->gender = $request->gender;
            $member->address = $address;
            $member->phone_number = trim($request->phone_number);
            $member->email = trim($request->email);
            $member->contact = $request->contact;
            $member->image_use = $request->photoUse;
            $member->note = $request->input('note', '');
            $member->save();

            $this->generateAndSaveQrCode($member, $request->expried_time);

            DB::commit();
            return redirect()->route('member.index')->with('success', 'Member and QR code created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function getFullNameCity($city_id){
        $query = DB::select('SELECT full_name FROM provinces WHERE code = ?',[$city_id]);
        return $query[0]->full_name ?? '';
    }

    public function getFullNameWard($ward_id){
        $query = DB::select('SELECT full_name FROM wards WHERE code = ?',[$ward_id]);
        return $query[0]->full_name ?? '';
    }

    public function getFullNamedistricts($district_id){
        $query = DB::select('SELECT full_name FROM districts WHERE code = ?',[$district_id]);
        return $query[0]->full_name ?? '';
    }
    /**
     * Tạo mã QR và lưu thông tin vào bảng QRCode
     */
    private function generateAndSaveQrCode(Member $member, $expried_time)
    {
        $code = 'MEM' . str_pad($member->id, 6, '0', STR_PAD_LEFT); // Ví dụ: MEM000001
        $qrImagePath = $this->generateQrCode($code);

        QRCode::create([
            'code' => $code,
            'qr_image' => $qrImagePath,
            'expried_time' => $expried_time,
            'member_id' => $member->id,
        ]);
    }

    /**
     * Tạo mã QR và lưu file ảnh vào thư mục công khai
     */
    public function generateQrCode($code)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($code)
            ->size(300)
            ->margin(10)
            ->build();

        $filePath = 'storage/qrcodes/' . $code . '.png';
        $result->saveToFile(public_path($filePath));

        return $filePath;
    }


    /**
     * Display the specified resource.
     */
    // app/Http/Controllers/MemberController.php
    public function show($id)
    {
        $person = Member::with('qrcodes')->find($id);

        if (!$person) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        // Trả về dữ liệu hội viên dưới dạng JSON
        return response()->json([
            'fullname' => $person->fullname,
            'qr_code' => $person->qrcodes->isNotEmpty() ? $person->qrcodes->first()->code : null
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();

            return response()->json(['message' => 'Xóa thành viên thành công'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Không thể xóa thành viên', 'error' => $e->getMessage()], 500);
        }
    }



    public function search(Request $request)
    {
        $searchName = $request->input('searchName');
        $members = Member::with(['qrcodes', 'users'])
            ->where('fullname', 'LIKE', '%' . $searchName . '%')
            ->get();

        return response()->json($members);
    }


    public function exportToCsv(Request $request)
    {
        $searchName = $request->input('searchName');
        if (!empty($searchName)) {
            $members = Member::with(['qrcodes', 'users'])
                ->where('fullname', 'LIKE', '%' . $searchName . '%')
                ->get();
        } else {
            $members = Member::with(['qrcodes', 'users'])->get();
        }

        $csvHeader = [
            'Member Id',
            'Qrcode',
            'Full Name',
            'Nickname',
            'Validity',
            'Address',
            'Phone Number',
            'E-mail',
            'Creator'
        ];

        $csvData = [];
        foreach ($members as $member) {
            $qrcode = $member->qrcodes->isNotEmpty() ? $member->qrcodes->first()->id : 'No QR Code';
            $validity = $member->qrcodes->isNotEmpty()
                ? \Carbon\Carbon::parse($member->qrcodes->first()->created_at)->format('Y-m-d H:i:s')
                . ' ~ ' .
                \Carbon\Carbon::parse($member->qrcodes->first()->expried_time)->format('Y-m-d H:i:s')
                : 'No Expiry';


            $role = $member->users ? ($member->users->role == 1 ? 'Admin' : 'Staff') : 'No User';

            $csvData[] = [
                $member->id,
                $qrcode,
                $member->fullname,
                $member->nickname,
                $validity,
                $member->address,
                $member->phone_number,
                $member->email,
                $role,
            ];
        }

        $filename = "members_list_" . now()->format('Y_m_d_H_i_s') . ".csv";

        return response()->stream(
            function () use ($csvHeader, $csvData) {
                $handle = fopen('php://output', 'w');
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
                fputcsv($handle, $csvHeader, ';');
                foreach ($csvData as $row) {
                    fputcsv($handle, $row, ';');
                }

                fclose($handle);
            },
            200,
            [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=\"$filename\"",
            ]
        );
    }
}


