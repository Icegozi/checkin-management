<style>
    .table-responsive {
        overflow-y: auto;
    }

    .table th,
    .table td {
        white-space: nowrap;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0.7;
        display: none;
    }
</style>


@extends('dashboard')
@section('title', 'Quản lý hội viên')
@section('content')
    <h3>Danh sách hội viên</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Search Section -->

    <div class="row mb-3">
        <!-- Họ tên và làm mới -->
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" id="searchName" placeholder="Họ tên">
                <button class="btn btn-outline-secondary" id="clear">Làm mới</button>
            </div>
        </div>
    
        <!-- Gia hạn -->
        <div class="col-md-6">
                <div class="input-group">
                    <select name="extend" id="extend_value" class="form-select" aria-placeholder="Gia hạn hội viên">
                        <option value="1">1 tháng</option>
                        <option value="3">3 tháng</option>
                        <option value="12">1 năm</option>
                    </select>
                    
                    <button class="btn btn-outline-secondary" id="extend">Gia hạn</button>
                </div>
        </div>
    </div>
    
        
    <!-- Navigation & Actions -->
<div class="d-flex justify-content-start ">
    <!-- Form Export -->
    <form action="{{ route('members.export') }}" method="get" class="d-inline ">
        <input type="hidden" id="tit" name="searchName" value="">
        <button type="submit" class="btn btn-lg">
            <i class="fa-solid fa-file-export"></i>
        </button>
    </form>

    <!-- Create Member -->
    <a href="{{ route('member.create') }}" class="btn btn-lg">
        <i class="fa-solid fa-plus"></i>
    </a>
</div>

    
    

    <!-- Lớp phủ mờ xung quanh -->
    <div id="overlay" class="overlay" style="display:none;"></div>

    <!-- Hộp thoại thông báo -->
    <div id="notificationDiv" class="notification"
        style="display:none; background-color: white; padding: 20px; margin: 0 auto; width: 35%; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000; border-radius: 8px;">
        <h5 class="fw-bold text-center mb-4">Thông tin hội viên</h5>
        <div class="d-flex align-items-center justify-content-between">
            <div class="col-md-3 d-flex justify-content-center align-items-center"
                style="height: 120px; width: 120px; border: 2px solid #007bff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <img class="qr-image" style="max-width: 100%; height: auto; border: 2px solid white; border-radius: 5px;"
                    src="{{ asset('storage/qrcodes/MEM000019.png') }}" alt="QR Code">
            </div>
            <div class="info-container" style=" flex-grow: 1; margin-left: 35px;">
                <div class="info-row d-flex justify-content-between mb-2">
                    <strong style="width: 30%;">Mã hội viên:</strong>
                    <span id="memberCode"></span>
                </div>
                <div class="info-row d-flex justify-content-between">
                    <strong style="width: 30%;">Họ tên:</strong>
                    <span id="memberName"></span>

                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button id="printButton" class="btn btn-outline-primary btn-sm">Print</button>
            <button id="cancelButton" class="btn btn-outline-danger btn-sm">Cancel</button>
        </div>
    </div>

    {{ $members->links() }}
    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-bordered" >
            <thead class="table-secondary">
                <tr>
                    <th></th>
                    <th>Qrcode</th>
                    <th>Họ tên</th>
                    <th>Nickname</th>
                    <th>Thời hạn hiệu lực</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>E-mail</th>
                    <th>Người tạo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot class="table-secondary">
                <tr>
                    <th></th>
                    <th>Qrcode</th>
                    <th>Họ tên</th>
                    <th>Nickname</th>
                    <th>Thời hạn hiệu lực</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>E-mail</th>
                    <th>Người tạo</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @isset($members)
                    @foreach ($members as $member)
                        <tr data-id="{{ $member->id }}">
                            <td class="text-center">
                                <input type="checkbox" id="member_id" name="member_id" value="{{ $member->id }}">
                            </td>
                            <td>
                                @if ($member->qrcodes->isNotEmpty())
                                    <a href="#">{{ $member->qrcodes->first()->code }}</a>
                                @else
                                    <span>No QR Code</span>
                                @endif
                            </td>
                            <td>{{ $member->fullname }}</td>
                            <td>{{ $member->nickname }}</td>
                            <td>
                                @if ($member->qrcodes->isNotEmpty())
                                    {{ \Carbon\Carbon::parse($member->qrcodes->first()->created_at)->format('Y-m-d H:i:s') }} ~
                                    {{ \Carbon\Carbon::parse($member->qrcodes->first()->expried_time)->format('Y-m-d H:i:s') }}
                                @else
                                    <span>No Expiry</span>
                                @endif
                            </td>
                            <td>{{ $member->address }}</td>
                            <td>{{ $member->phone_number }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                <!-- Kiểm tra role của User, nếu có -->
                                @if ($member->users)
                                    {{ $member->users->role == 1 ? 'Admin' : 'Staff' }}
                                @else
                                    <span>No User</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-lg  showMember"><i class="fa-regular fa-eye"></i></a>
                                {{-- <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-lg "><i class="fa-solid fa-trash-can"></i></button>
                                </form> --}}
                                <button class="btn btn-lg deleteMember"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endisset

                {{-- <tr>
                    <td>2</td>
                    <td><a href="#">M000002</a></td>
                    <td>テスト太郎2</td>
                    <td>テストタロウ2</td>
                    <td>2024/01/01 ~ 2024/12/31</td>
                    <td>〒111-222</td>
                    <td>01-1111-2222</td>
                    <td>tarou2@gmail.com</td>
                    <td>admin</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Print</a>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr> --}}
                <!-- Repeat rows for other members -->
            </tbody>
        </table>

    </div>
    
    
@endsection

