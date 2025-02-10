<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
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
        body, html {
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
        <source src="{{asset('assets/images/background.mp4')}}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Login Form -->
    <div class="auth-main">
        <div class="auth-wrapper">
                    <h3 class="mb-3 text-center">Đăng nhập</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                                <label class="form-check-label" for="remember">Duy trì đăng nhập</label>
                            </div>
                            <a href="{{route('password.request')}}" class="text-secondary">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="btn btn-outline-dark w-100">Đăng nhập</button>
                    </form>

        </div>
    </div>
</body>

</html>
