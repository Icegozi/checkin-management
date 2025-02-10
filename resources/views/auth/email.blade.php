<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forget Passwoed</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="https://mantisdashboard.io/bootstrap/free/assets/images/favicon.svg" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap"
        id="main-font-link">
    <!-- [Bootstrap CSS] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Public Sans', sans-serif;
            overflow: hidden;
        }

        /* Video background */
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .auth-main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-wrapper {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h3 {
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
   
    </style>
</head>

<body>
    <!-- Video Background -->
    <video class="video-bg" autoplay muted loop>
        <source src="{{ asset('assets/images/background.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Login Form -->
    <div class="auth-main">
        <div class="auth-wrapper">
            <a href="{{route('login.form')}}" class="text-secondary">Quay lai </a>
            <h3 class="mb-3 text-center">Quên mật khẩu</h3>
            @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            @csrf

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Nhập email của bạn:</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>

                
                <button type="submit" class="btn btn-outline-dark w-100">Gửi link đặt lại mật khẩu</button>
            </form>

        </div>
    </div>
</body>

</html>
