@extends('admin.dashboard')
@section('title', 'Add Staff')
@section('content')
<div class="container-fluid ">
    <!-- Page Heading -->
    <h3 class="mb-4">Tạo mới nhân viên</h3>

    <!-- Form -->
    <div class=mb-4">
        
        <div >
            <form action="{{ route('staff.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label  for="name"> Họ tên</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="address"> Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="address"> Mật khẩu</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="status"> Trạng thái</label>
                        <select class="form-control custom-select" id="status" name="status" required>
                            <option value="0">Đang bảo trì</option>
                            <option value="1">Đang hoạt động</option>
                            <option value="2">Đã khóa</option>
                        </select>
                    </div>
                    
                    
                    
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="password_confirmation"> Xác nhận mật khẩu</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="address"> Email</label>
                        <div class="input-group">
                            
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-dark btn-sm"> Thêm nhân viên</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    label{
        font-weight: 500;
    }
</style>