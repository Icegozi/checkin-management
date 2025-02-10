<style>
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        /* Kích hoạt cuộn ngang */
        white-space: nowrap;
        /* Đảm bảo nội dung không tự xuống dòng */
    }

    table td,
    table th {
        white-space: nowrap;
        /* Nội dung không xuống dòng */
    }

    }
</style>
@extends('admin.dashboard')
@section('title', 'Staff Management')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách nhân viên</h1>
        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif



        <!-- DataTales Example -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary  d-flex align-items-center justify-content-center">

                <a href="{{ route('staff.create') }}" class="btn  btn-lg" style="width:8%">
                    <i class="fa-solid fa-plus mr-1"></i>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-secondary">
                        <tr>
                            <th>Id</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th>Thời gian cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tfoot class="table-secondary">
                        <tr>
                            <th>Id</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th>Thời gian cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @isset($staffs)
                            @foreach ($staffs as $staff)
                                <tr>
                                    <td>{{ $staff['id'] }}</td>
                                    <td>{{ $staff['name'] }}</td>
                                    <td>{{ $staff['email'] }}</td>
                                    <td>{{ $staff['address'] }}</td>
                                    <td>
                                        @if ($staff['status'] == 0)
                                            Đang bảo trì
                                        @elseif ($staff['status'] == 1)
                                            Đang hoạt động
                                        @else
                                            Đã khóa
                                        @endif

                                    </td>
                                    <td>{{ $staff['created_at'] }}</td>
                                    <td>{{ $staff['updated_at'] }}</td>
                                    <td style="display: flex">
                                        <a href="{{ route('staff.edit', $staff['id']) }}" class="btn btn-lg"
                                            style="width: 60px; height:30px; margin-right:10px"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('staff.destroy', $staff['id']) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn  btn-lg"
                                                onclick="return confirm('Are you sure you want to delete this staff?')"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                        <!-- Thêm các hàng khác tại đây -->
                    </tbody>
                </table>

            </div>
            {{ $staffs->links() }}
        </div>
    </div>
@endsection

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
