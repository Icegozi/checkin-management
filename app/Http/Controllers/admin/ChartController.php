<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Throw_;

class ChartController extends Controller
{

    public function getCheckinData()
    {
        $data = Checkin::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($data);
    }
    public function getStatistical(Request $request)
    {
        try {
            $startDate = date('Y-m-d H:i:s', strtotime($request->dstartdate));
            $endDate = date('Y-m-d H:i:s', strtotime($request->denddate));


            $isMember = filter_var($request->dmember, FILTER_VALIDATE_BOOLEAN);
            $isNonMember = filter_var($request->dnonmember, FILTER_VALIDATE_BOOLEAN);
            $isBelow18 = filter_var($request->dbelow18, FILTER_VALIDATE_BOOLEAN);
            $isAbove19 = filter_var($request->dabove19, FILTER_VALIDATE_BOOLEAN);

            Log::info([
                'startDate' => $startDate,
                'endDate' => $endDate,
                'isMember' => $isMember,
                'isMemberType' => gettype($isMember),
                'isNonMember' => $isNonMember,
                'isNonMemberType' => gettype($isNonMember),
                'isBelow18' => $isBelow18,
                'isBelow18Type' => gettype($isBelow18),
                'isAbove19' => $isAbove19,
                'isAbove19Type' => gettype($isAbove19),
            ]);

            if (empty($startDate) && empty($endDate) && !$isMember && !$isNonMember && !$isBelow18 && !$isAbove19) {
                return $this->getCheckinData();
            }

            if ($endDate < $startDate) {
                throw new Exception('Ngày/Tháng kết thúc không được trước thời điểm Ngày/Tháng bắt đầu!');
            }

            if (strtotime($startDate) == 0 && strtotime($endDate) == 0 && $isMember || strtotime($startDate) == 0 && strtotime($endDate) == 0 && $isNonMember) {
                throw new Exception('Ngày tháng không được để trống trước khi thao tác tiếp!');
            }

            $result = Checkin::select('checkins.*', 'members.birthday', 'members.id as member_id')
                ->leftJoin('members', 'checkins.member_id', '=', 'members.id')
                ->whereBetween('checkins.created_at', [$startDate, $endDate])
                ->get();

            $filteredData = $result->filter(function ($item) use ($isMember, $isNonMember, $isBelow18, $isAbove19) {
                if ($isMember && $item->role != 0) {
                    return false;
                }
                if ($isNonMember && $item->role != 1) {
                    return false;
                }

                if ($isBelow18 && (now()->diffInYears($item->birthday) >= 18)) {
                    return false;
                }
                if ($isAbove19 && (now()->diffInYears($item->birthday) < 19)) {
                    return false;
                }

                return true;
            });

            $groupedData = $filteredData->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
            })->map(function ($group) {
                return [
                    'date' => $group->first()->created_at->format('Y-m-d'),
                    'total' => $group->count(),
                ];
            })->values();

            
            if ($groupedData->isEmpty()) {
                return response()->json(['message' => 'Không có dữ liệu phù hợp.']);
            }

            return response()->json($groupedData);
        } catch (Exception $e) {
            Log::error('Error fetching statistical data: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }





    public function index()
    {
        $datas = Checkin::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return view('admin.pages.chart.index', compact('datas'));
    }
}
