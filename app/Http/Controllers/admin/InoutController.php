<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InoutController extends Controller
{
    public function index(){
        $today = Carbon::today(); 

        $nonmembertodays = Checkin::where('role', 1)
            ->whereDate('created_at', $today) 
            ->orderBy('created_at', 'DESC') 
            ->paginate(10);

        $membertodays = Checkin::where('role', 0)
        ->leftJoin('members', 'checkins.member_id', '=', 'members.id')
        ->select('checkins.*', 'members.*') // Không cần alias 'checkin_created_at'
        ->whereDate('checkins.created_at', $today)  // Dùng trường 'created_at' từ bảng 'checkins'
        ->orderBy('checkins.created_at', 'DESC') 
        ->paginate(10);

        $nonmembers = Checkin::where('role',1)->orderBy('created_at','DESC')->paginate(10);
        $members = Checkin::where('role', 0)
        ->leftJoin('members', 'checkins.member_id', '=', 'members.id') 
        ->select('checkins.*', 'members.*', 'checkins.created_at as checkin_created_at') 
        ->orderBy('checkins.created_at', 'DESC') 
        ->paginate(10);

        Log::info("không phải member: $nonmembers" );
        Log::info("Member:  $members");

        return view('admin.pages.inout.index',compact('nonmembers','members','nonmembertodays','membertodays'));
    }
}
