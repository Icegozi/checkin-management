<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Qrcode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckinController extends Controller
{
    public function index()
    {
        return view('staff.pages.checkin');
    }

    public function searchQRCode(Request $request)
    {
        $qrcode = Qrcode::where('code', $request->qrcode)->with('members')->first();

        if ($qrcode) {
            // Chuyển đổi giá trị gender
            $gender = $qrcode->members->gender == 1 ? 'Nam' : ($qrcode->members->gender == 0 ? 'Nữ' : 'Khác');


            return response()->json([
                'status' => 'success',
                'data' => [
                    'fullname' => $qrcode->members->fullname,
                    'phone' => $qrcode->members->phone_number,
                    'gender' => $gender,
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy hội viên với mã QR này!'
            ]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $qrcodes = Qrcode::where('code', $request->qrcode)->with('members')->first();

            if ($qrcodes) {
                $qrcode_id = $qrcodes->id;
                $member_id = $qrcodes->members->id;

                if (strtotime($qrcodes->expried_time) < time()) {
                    throw new Exception("Mã QR đã hết hạn.");
                }
                // Lưu thông tin check-in
                Checkin::create([
                    'qrcode_id' => $qrcode_id,
                    'member_id' => $member_id,
                ]);


                DB::commit();  // Commit transaction nếu không có lỗi
                $mess = 'Check-in thành công cho anh/chị ' . $qrcodes->members->fullname;
                return response()->json([
                    'status' => 'success',
                    'message' => $mess,
                ]);
            } else {
                DB::rollBack();  // Rollback nếu không tìm thấy mã QR
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy hội viên với mã QR này!',
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function nstore(Request $request)
    {
        DB::beginTransaction();  // Bắt đầu transaction

        try {
            if (empty($request->nfullname)) {
                throw new Exception("Họ và tên là bắt buộc.");
            }
            if (!is_string($request->nfullname) || strlen($request->nfullname) > 255) {
                throw new Exception("Họ và tên phải là chuỗi và không được vượt quá 255 ký tự.");
            }

            if (empty($request->nphone)) {
                throw new Exception("Số điện thoại là bắt buộc.");
            }
            if (!preg_match('/^\d{10,11}$/', $request->nphone)) {
                throw new Exception("Số điện thoại phải có độ dài từ 10 đến 11 chữ số.");
            }

            $fullname = trim(ucwords(strtolower($request->nfullname)));
            $phone = trim($request->nphone);
            $birthday = $request->nbirthday;

            if (empty($birthday)) {
                throw new Exception("Ngày sinh là bắt buộc.");
            }
            if (strtotime($birthday) > time()) {
                throw new Exception("Ngày sinh không hợp lệ.");
            }
            Checkin::create([
                'role' => 1,
                'fullname' => $fullname,
                'phone_number' => $phone,
                'birthday' => $birthday,
            ]);

            DB::commit();
            $mess = 'Check-in thành công cho anh/chị ' . $fullname;
            return response()->json([
                'status' => 'success',
                'message' => $mess,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
