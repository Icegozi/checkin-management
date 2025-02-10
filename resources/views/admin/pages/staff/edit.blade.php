@extends('admin.dashboard')
@section('title', 'Update Staff')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h3 class="mb-4 ">Sửa thông tin nhân viên</h3>
        @if ($errors->any()) 
        <div class="alert alert-danger"> 
                @foreach ($errors->all() as $error)
                 <p>{{ $error }}</p>
                 @endforeach 
            </div> 
        @endif
        <!-- Form -->
        <div >
            
            <div class="">
                <form action="{{ route('staff.update',$staffs['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name"> Họ tên</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter name" value="{{ $staffs['name'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address"> Email</label>
                        <div class="input-group">

                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter email" value="{{ $staffs['email'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address"> Mật khẩu</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation"> Xác nhận mật khẩu</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm password" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address"> Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address"
                            value="{{ $staffs['address'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="status"> Trạng thái</label>
                        <select class="form-control custom-select" id="status" name="status" required>


                            @switch($staffs['status'])
                                @case(0)
                                    <option value="0">Đang bảo trì</option>
                                    <option value="1">Đang hoạt động</option>
                                    <option value="2">Đã khóa</option>
                                @break

                                @case(1)
                                    <option value="0">Đang bảo trì</option>
                                    <option value="1">Đang hoạt động</option>
                                    <option value="2">Đã khóa</option>
                                @break

                                @case(2)
                                    <option value="0">Đang bảo trì</option>
                                    <option value="1">Đang hoạt động</option>
                                    <option value="2">Đã khóa</option>
                                @break

                                @default
                                    <option value="0">Đang bảo trì</option>
                                    <option value="1">Đang hoạt động</option>
                                    <option value="2">Đã khóa</option>
                            @endswitch

                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-dark btn-sm"> Lưu nhân viên
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
