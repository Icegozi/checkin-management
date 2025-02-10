@if(auth()->check())
    @if(auth()->user()->role === 0)
        @include('staff.dashboard')
    @else
        @include('admin.dashboard')
    @endif
@else
    {{-- Chuyển hướng đến trang đăng nhập hoặc hiển thị thông báo --}}
    <script>
        window.location.href = "{{route('login')}}";
    </script>
@endif
