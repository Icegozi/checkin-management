@extends('admin.dashboard')
@section('title', 'Quản lý vào ra')
@section('content')
<style>
    .num{
        color: blue;
    }
</style>
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="true">Hội viên</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">Không phải hội viên</a>
    </li>
</ul>
  
<!-- Tab panes -->
<div class="tab-content mt-3">
    <div class="tab-pane container fade show active" id="menu1" role="tabpanel" aria-labelledby="home-tab">
        <p class="text-muted num" >Số lượt ra vào trong {{" ". \Carbon\Carbon::today()->format('Y-m-d') . " "}} của hội viên:{{" ".$membertodays->count()}}</p>
        <table class="table table-bordered ">
            <thead class="table-secondary">
                <tr> 
                    <th scope="col" class="text-center">Họ tên</th>
                    <th scope="col" class="text-center">Số điện thoại</th>
                    <th scope="col" class="text-center">Sinh nhật</th>
                    <th scope="col" class="text-center">Thời gian</th>
                </tr>
            </thead>
            <tfoot class="table-secondary">
                <tr> 
                    <th scope="col" class="text-center">Họ tên</th>
                    <th scope="col" class="text-center">Số điện thoại</th>
                    <th scope="col" class="text-center">Sinh nhật</th>
                    <th scope="col" class="text-center">Thời gian</th>
                </tr>
            </tfoot>
            <tbody>
                @isset($members)
                    @foreach ($members as $member)
                        <tr >
                            <td class="text-center">{{ $member['fullname'] }}</td>
                            <td class="text-center">{{ $member['phone_number'] }}</td>
                            <td class="text-center">{{ $member['birthday'] }}</td>
                            {{-- <td class="text-center">{{ \Carbon\Carbon::parse($member['created_at'])->format('d/m/Y H:i') }}</td> --}}
                            <td class="text-center">{{ $member['checkin_created_at']}}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        {{$members->links()}}
    </div>
    <div class="tab-pane container fade" id="menu2" role="tabpanel" aria-labelledby="profile-tab">
        <p  class="text-muted num" >Số lượt ra vào trong {{" ". \Carbon\Carbon::today()->format('Y-m-d') . " "}} không phải hội viên:{{" ".$nonmembertodays->count()}}</p>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr> 
                    <th scope="col" class="text-center">Họ tên</th>
                    <th scope="col" class="text-center">Số điện thoại</th>
                    <th scope="col" class="text-center">Sinh nhật</th>
                    <th scope="col" class="text-center">Thời gian</th>
                </tr>
            </thead>
            <tfoot class="table-secondary">
                <tr> 
                    <th scope="col" class="text-center">Họ tên</th>
                    <th scope="col" class="text-center">Số điện thoại</th>
                    <th scope="col" class="text-center">Sinh nhật</th>
                    <th scope="col" class="text-center">Thời gian</th>
                </tr>
            </tfoot>
            <tbody>
                @isset($nonmembers)
                    @foreach ($nonmembers as $member)
                        <tr>
                            <td class="text-center">{{ $member['fullname'] }}</td>
                            <td class="text-center">{{ $member['phone_number'] }}</td>
                            <td class="text-center">{{ $member['birthday'] }}</td>
                            {{-- <td class="text-center">{{ \Carbon\Carbon::parse($member['created_at'])->format('d/m/Y H:i') }}</td> --}}
                            <td class="text-center">{{ $member['created_at']}}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        {{$nonmembers->links()}}
    </div>
</div>

@endsection
