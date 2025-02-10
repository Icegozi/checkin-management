@extends('dashboard')
@section('title', 'Staff Management')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <div class="container-fluid">
        <form action="{{ route('member.store') }}" method="POST">
            <div class=" mt4 d-flex justify-content-between">
                <h3 class="">Tạo mới member</h3>

                <div class="d-flex justify-content-center mb-2">
                    <a href="{{ route('member.index') }}" class="btn btn-secondary ">List</a>
                    <button type="submit" class="btn btn-primary ms-2">Save</button>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf
            <!-- Họ tên và Nickname -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="hoTen" class="form-label">Họ tên</label>
                    <input type="text" id="hoTen" class="form-control" placeholder="Nhập họ tên" name="fullname">
                </div>
                <div class="col-md-6">
                    <label for="nickname" class="form-label">Nickname</label>
                    <input type="text" id="nickname" class="form-control" placeholder="Nhập nickname" name="nickname">
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            </div>

            <!-- Ngày tháng năm sinh và Giới tính -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="dob" class="form-label">Ngày tháng năm sinh</label>
                    <input type="date" id="dob" class="form-control" name="birthday">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Giới tính</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="1">
                        <label class="form-check-label" for="male">Nam</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="0">
                        <label class="form-check-label" for="female">Nữ</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="other" value="2">
                        <label class="form-check-label" for="other">Khác</label>
                    </div>
                </div>
                <div class="col-md-3  d-flex justify-content-center align-items-center"
                    style="height: 110px;width:110px; border: 2px solid #007bff; border-radius: 10px;">
                    <img class="qr-image"
                        style="max-width: 100%; height: auto; border: 2px solid white; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);"
                        src="{{ asset('storage/qrcodes/MEM000019.png') }}" alt="QR Code">
                </div>



            </div>

            @csrf
        <!-- Địa chỉ -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="provinceSelect" class="form-label">Tỉnh thành</label>
                <select id="provinceSelect" class="form-select" name="city">
                    <option selected value="">Chọn tỉnh/thành phố</option>
                    <!-- Province options will load dynamically here -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="districtSelect" class="form-label">Quận/Huyện</label>
                <select id="districtSelect" class="form-select" name="district" disabled>
                    <option selected value="">Chọn quận/huyện</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="wardSelect" class="form-label">Phường/Xã</label>
                <select id="wardSelect" class="form-select" name="ward" disabled>
                    <option selected value="">Chọn phường/xã</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="address" class="form-label">Địa chỉ chi tiết</label>
                <input type="text" id="address" class="form-control" placeholder="Nhập địa chỉ" name="address_detail">
            </div>
        </div>
        


            <!-- Số điện thoại và Email -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" id="phone" class="form-control" placeholder="Nhập số điện thoại"
                        name="phone_number">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="Nhập email" name="email">
                </div>
            </div>

            <!-- Thời hạn hiệu lực và Hội viên năm -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="validity" class="form-label">Thời hạn hiệu lực</label>
                    <input type="datetime-local" id="validity" class="form-control"
                        placeholder="2024/02/01 ~ 2024/12/30" name="expried_time">
                </div>
                <div class="col-md-6">
                    <label for="membershipFee" class="form-label">Phí hội viên (Tháng)</label>
                    <input type="text" id="membershipFee" class="form-control" placeholder="2000000 VND"
                        name="membership_fee">
                </div>
            </div>

            <!-- Liên lạc và Ảnh sử dụng -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Liên lạc</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="contact" id="contactYes" value="1">
                        <label class="form-check-label" for="contactYes">Có thể</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="contact" id="contactNo" value="0">
                        <label class="form-check-label" for="contactNo">Không thể</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ảnh sử dụng</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="photoUse" id="photoYes" value="1">
                        <label class="form-check-label" for="photoYes">Có thể</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="photoUse" id="photoNo" value="0">
                        <label class="form-check-label" for="photoNo">Không thể</label>
                    </div>
                </div>
            </div>

            <!-- Ghi chú -->
            <div class="mb-3">
                <label for="note" class="form-label">Ghi chú</label>
                <textarea id="note" class="form-control" rows="3"></textarea>
            </div>


        </form>
    </div>
    <script>
        $(document).ready(function () {
    // Load provinces
    $.ajax({
        url: '/api/provinces',
        method: 'GET',
        success: function (data) {
            let provinceSelect = $('#provinceSelect');
            provinceSelect.empty().append('<option value="">Chọn tỉnh/thành phố</option>');
            data.forEach(function (province) {
                provinceSelect.append(
                    `<option value="${province.code}">${province.full_name}</option>`
                );
            });
        },
        error: function () {
            alert('Không thể tải danh sách tỉnh/thành phố.');
        },
    });

    // Khi chọn tỉnh/thành phố
    $('#provinceSelect').on('change', function () {
        let provinceCode = $(this).val();
        let districtSelect = $('#districtSelect');
        let wardSelect = $('#wardSelect');

        districtSelect.prop('disabled', true).empty().append('<option value="">Chọn quận/huyện</option>');
        wardSelect.prop('disabled', true).empty().append('<option value="">Chọn phường/xã</option>');

        if (provinceCode) {
            $.ajax({
                url: `/api/districts/${provinceCode}`,
                method: 'GET',
                success: function (data) {
                    districtSelect.prop('disabled', false); 
                    data.forEach(function (district) {
                        districtSelect.append(
                            `<option value="${district.code}">${district.full_name}</option>`
                        );
                    });
                },
                error: function () {
                    alert('Không thể tải danh sách quận/huyện.');
                },
            });
        }
    });

    // Khi chọn quận/huyện
    $('#districtSelect').on('change', function () {
        let districtCode = $(this).val();
        let wardSelect = $('#wardSelect');

        // Reset dropdown và khóa lại
        wardSelect.prop('disabled', true).empty().append('<option value="">Chọn phường/xã</option>');

        if (districtCode) {
            $.ajax({
                url: `/api/wards/${districtCode}`,
                method: 'GET',
                success: function (data) {
                    wardSelect.prop('disabled', false); 
                    data.forEach(function (ward) {
                        wardSelect.append(
                            `<option value="${ward.code}">${ward.full_name}</option>`
                        );
                    });
                },
                error: function () {
                    alert('Không thể tải danh sách phường/xã.');
                },
            });
        }
    });
});
    </script>
@endsection

