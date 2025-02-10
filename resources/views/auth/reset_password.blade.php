<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin-left: -700px;
            overflow: hidden;

        }

        /* Video background */
        video#background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            /* Đưa video xuống dưới */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 600px;
            height: 450px;
            z-index: 1;
        }

        .form-section {
            padding: 20px 20px;
            width: 100%;
        }


        .form-label {
            font-weight: 600;
        }

        .link {
            display: block;
            text-align: left;
            margin-right: 5px;
            font-weight: 500;
            font-size: 16px;
            color: #6c757d;
            text-decoration: none;
            margin-bottom: 30px;
            
            transition: color 0.3s ease;
        }

        .link:hover {
            color: #343a40;
            text-decoration: underline;
        }

        .user{
            display: flex;
            margin-top: 20px;
        }

    </style>
</head>

<body>
    <!-- Video Background -->
    <video id="background-video" autoplay loop muted>
        <source src="{{ asset('assets/images/background.mp4') }}" type="video/mp4">
        Trình duyệt của bạn không hỗ trợ video.
    </video>
    <div class="container">
        <!-- Image Section -->
        {{-- <div class="image-section col-sm-6">
            <img src="{{ asset('assets/images/background.jpg') }}" alt="Hình ảnh không tồn tại">
        </div> --}}

        <!-- Form Section -->
        <div class="form-section col-sm-6">
            
            <div class="user">
                <a class="link" href="{{ route('logout') }}">Đăng xuất?</a>
                <p>{{auth()->user()->name}}</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
            
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Mật khẩu mới:</label>
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="Nhập mật khẩu mới" required>
                </div>
                <div class="form-group mb-4">
                    <label for="password_confirmation" class="form-label">Nhập lại mật khẩu:</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                        placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-outline-dark w-100">Cập nhật</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
