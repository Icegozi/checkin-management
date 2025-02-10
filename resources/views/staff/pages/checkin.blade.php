@extends('dashboard')
@section('title', 'Check in')
@section('content')
    <style>
        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #4CAF50;
            /* Màu xanh lá cây */
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: auto;
        }

        .price::before {
            content: "💰 ";
            font-size: 1.5rem;
        }

        .price::after {
            content: " 💸";
            font-size: 1.5rem;
        }

        /* Lật hình ảnh khi sử dụng camera trước */
        #reader video {
            transform: scaleX(-1);
            /* Lật hình ảnh để không bị gương */
        }

        /* Giữ nguyên phần còn lại của cấu trúc CSS */
        .camera-reader {
            width: 400px;
            height: 300px;
            margin: 0 auto;
            background: none;
            border: none;
            box-shadow: none;
            position: relative;
        }

        .camera-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 999;
        }

        #reader {
            width: 100%;
            height: 100%;
            display: block;
            background: none;
            border: none;
            box-shadow: none;
        }

        /* Nút đóng modal */
        .camera-close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .camera-container.hidden {
            display: none;
        }
    </style>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab"
                aria-controls="home" aria-selected="true">Dành cho hội viên</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab"
                aria-controls="profile" aria-selected="false">Sử dụng 1 ngày</button>
        </li>
        <li class="nav-item" role="presentation">

        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            <div class="container mt-3">
                <p id="nofication" style="color: green; display:none"></p>
                <form>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">No <sub
                                    style="color:red; font-size:15px; margin-left:5px">*</sub></span>
                        </div>
                        <div class="custom-file">
                            <input type="text" class="form-control" placeholder="MEM0000000"
                                aria-label="Recipient's username" aria-describedby="button-addon2" id="qrcode">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Họ Tên</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="fullname" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Số điện thoại</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="phone" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Giới tính</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="gender" readonly>
                    </div>


                    <button type="button" class="btn btn-outline-secondary  btn-checkin mt-4 mb-4"
                        id="checkin">Checkin</button>
                    <button type="button" class="btn btn-outline-secondary  btn-checkin mt-4 mb-4"
                        id="autocheckin">Automatic Checkin</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container mt-3">
                <p id="nofication2" style="color: green; display:none"></p>
                
                <form>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Họ Tên</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="nfullname">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Số điện thoại</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="nphone">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Ngày sinh</span>
                        </div>
                       
                            <input type="date" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" name="nbirthday" id="birthday"> 

                            <p id="age" class="ml-2" style="color: #4CAF50; display:none">ssssss</p>
                      
                    </div>
                    <button type="button" class="btn btn-outline-secondary  btn-checkin mt-4 mb-4"
                        id="ncheckin">Checkin</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/html5-qrcode.min.js') }}"></script>
<div class="camera-container hidden" id="cameraOverlay">
    <div class="camera-reader">
        <button class="camera-close-button" id="closeCamera">&times;</button>
        <div id="reader"></div>

    </div>
</div>

<p id="qr-result" style="color: green; font-weight: bold; display: none;">Quét thành công!</p>


<script>
    $(document).ready(function() {
        //Chức năng tính tuổi
        $('#birthday').off('change').on('change', function () {
            let birthday = $(this).val();
            if (!birthday) {
                $('#age').text('Vui lòng chọn ngày sinh.').css('display', 'block');
                return;
            }
            let birthDate = new Date(birthday);
            let today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            let monthDifference = today.getMonth() - birthDate.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (age >= 0) {
                $('#age').text(`${age} tuổi.`).css('display', 'block');
            } else {
                $('#age').text('Ngày sinh không hợp lệ!').css('display', 'block');
            }
        });

        //Chức năng tìm kiếm hội viên
        $('#button-addon2').off('click').on('click', function() {
            let code = $('#qrcode').val();

            $('input[name="fullname"]').val('');
            $('input[name="phone"]').val('');
            $('input[name="gender"]').val('');

            $.ajax({
                url: '/search-qrcode',
                type: 'GET',
                data: {
                    qrcode: code
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('input[name="fullname"]').val(response.data.fullname);
                        $('input[name="phone"]').val(response.data.phone);
                        $('input[name="gender"]').val(response.data.gender)


                    } else {
                        alert('Không tìm thấy thông tin!');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Đã xảy ra lỗi khi tìm kiếm mã QR.');
                }
            });
        });

        //Chức năng checkin cho hội viên
        $('#checkin').off('click').on('click', function() {
            let code = $('#qrcode').val();
            $.ajax({
                url: '/checkin',
                type: 'POST',
                data: {
                    qrcode: code,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Check in thành công');
                        $('#nofication').text(response.message).css('color', 'green');
                        $('#nofication').show();
                    } else {
                        alert(response.message);
                        $('#nofication').text(response.message).css('color','red');
                        $('#nofication').show();
                    }
                },
                error: function(xhr, status, error) {
                    alert('Đã xảy ra lỗi khi tìm kiếm mã QR.');
                }
            });
        });

        //Chức năng check in cho người không là hội viên
        $('#ncheckin').click(function() {
            var fullname = $('input[name="nfullname"]').val();
            var phone = $('input[name="nphone"]').val();
            var birthday = $('input[name="nbirthday"]').val();
            console.log(birthday);
            
            $.ajax({
                url: '/ncheckin',
                method: 'POST',
                data: {
                    nfullname: fullname,
                    nphone: phone,
                    nbirthday: birthday,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#nofication2').text(response.message).css('color', 'green')
                            .show();
                        $('input[name="nfullname"]').val('');
                        $('input[name="nphone"]').val('');
                        $('input[name="nbirthday"]').val('');
                    } else {
                        $('#nofication2').text(response.message).css('color', 'red').show();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        for (var field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorMessage += errors[field][0] + ' ';
                            }
                        }

                        $('#nofication2').text(errorMessage).css('color', 'red').show();
                    } else {
                        $('#nofication2').text('Đã xảy ra lỗi!').css('color', 'red').show();
                    }
                }
            });
        });

        let html5QrcodeScanner;
        const qrCodeRegionId = "reader";

        // Chức năng Automatic Checkin
        $("#autocheckin").click(function() {
            $("#cameraOverlay").removeClass("hidden");

            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5Qrcode(qrCodeRegionId);
            }
            html5QrcodeScanner
                .start({
                        facingMode: "user" 
                    }, 
                    {
                        fps: 30,
                        qrbox: {
                            width: 200,
                            height: 200
                        },
                        showTorchButtonIfSupported: true
                    }, 
                    function(decodedText) {
                        alert(`Quét thành công! Mã: ${decodedText}`);
                        html5QrcodeScanner.stop().then(() => {
                            $("#cameraOverlay").addClass("hidden");
                        });

                        $.ajax({
                            url: "/checkin",
                            type: "POST",
                            data: {
                                qrcode: decodedText,
                                _token: $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function(response) { 
                                $('#nofication').text(response.message).css('color','blue').show();
                            },
                            error: function(xhr) {
                                alert("Lỗi khi check-in.");
                            },
                        });
                    },
                    function(errorMessage) {
                        console.warn("Lỗi quét QR: ", errorMessage);
                    }
                )
                .catch((err) => {
                    console.error("Lỗi khi khởi chạy quét QR: ", err);
                });
        });

        $("#closeCamera").click(function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    $("#cameraOverlay").addClass("hidden");
                });
            } else {
                $("#cameraOverlay").addClass("hidden");
            }
        });

    });
</script>
