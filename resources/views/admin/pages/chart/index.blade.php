@extends('admin.dashboard')
@section('title', 'Thống kê Check-in')
@section('content')

    <!-- Thông tin bộ lọc -->
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Đối tượng thống kê
            </div>
            <div class="card-body">
                <p id="nofi" style="display:none; color:red;"></p>

                <form id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Từ tháng *</label>
                            <input type="month" id="startDate" class="form-control" value="2023-02">
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">Đến tháng *</label>
                            <input type="month" id="endDate" class="form-control" value="2024-02">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type *</label>
                            <select id="type" class="form-select" id="type">
                                <option value="ngay">Ngày</option>
                                <option value="thang" selected>Tháng</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="target" class="form-label">Target</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="member" checked>
                                <label class="form-check-label" for="member">Hội viên</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="nonMember">
                                <label class="form-check-label" for="nonMember">Không phải hội viên</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="age" class="form-label">Tuổi</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="below18">
                                <label class="form-check-label" for="below18">Cho đến 18 tuổi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="above19">
                                <label class="form-check-label" for="above19">Từ trên 19 tuổi</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-outline-dark" id="clearFilters">Clear</button>
                            <button type="button" class="btn btn-outline-dark" id="filterSubmit">Thống kê</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-6" id="allDataContainer">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-center text-muted">Toàn bộ dữ liệu</h5>
                        <canvas id="checkinChartall" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6" id="filteredDataContainer" >
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-center text-muted" id="loc" style="display: none;">Dữ liệu được lọc
                        </h5>
                        <canvas id="checkinChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Import các thư viện -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script để tạo biểu đồ -->
    <script>
        $(document).ready(function() {
            $("#filteredDataContainer").hide(function() {
                    $("#allDataContainer").removeClass("col-md-6").addClass("col-12");
                });

            const datas = @json($datas);
            $(document).ready(function() {
                const labels = [];
                const values = [];

                datas.forEach(data => {
                    labels.push(data.date);
                    values.push(data.total);
                });

                // Tạo biểu đồ
                const ctx = $('#checkinChartall')[0].getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số lượt Check-in',
                            data: values,
                            borderColor: 'rgba(255, 165, 0, 1)',
                            backgroundColor: 'rgba(255, 165, 0, 0.5)',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Số lượt Check-in'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Ngày'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });






            $('#type').off('change').on('change', function() {
                let type = $(this).val();
                if (type == 'ngay') {
                    $('#startDate').attr('type', 'date');
                    $('#endDate').attr('type', 'date');
                } else {
                    $('#startDate').attr('type', 'month');
                    $('#endDate').attr('type', 'month');
                }
            });

            let checkinChart = null; // Khởi tạo biến toàn cục

            $('#filterSubmit').off('click').on('click', function() {
                let startdate = $('#startDate').val();
                let enddate = $('#endDate').val();
                let member = $('#member').is(':checked');
                let nonmember = $('#nonMember').is(':checked');
                let below18 = $('#below18').is(':checked');
                let above19 = $('#above19').is(':checked');
                $("#filteredDataContainer").show(function() {
                    $("#allDataContainer").removeClass("col-12").addClass("col-md-6");
                    $("#filteredDataContainer").addClass("col-md-6");
                });

                
                $('#loc').show();
                $.ajax({
                    url: '/admin/dashboard/statistical',
                    method: 'GET',
                    data: {
                        dstartdate: startdate,
                        denddate: enddate,
                        dmember: member,
                        dnonmember: nonmember,
                        dbelow18: below18,
                        dabove19: above19,
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status === 'error') {
                            $('#nofi').text(data.message)
                                .css('color', 'red')
                                .show();
                        } else {
                            const labels = [];
                            const values = [];
                            $('#nofi').text("Dữ liệu đã được thêm vào đồ thị.")
                                .css('color', 'green')
                                .show();

                            // Lọc và duyệt qua data để lấy labels và values
                            for (let i = 0; i < data.length; i++) {
                                if (data[i].date && data[i]
                                    .total) { // Chỉ thêm nếu cả ngày và giá trị tồn tại
                                    labels.push(data[i].date);
                                    values.push(data[i].total);
                                }
                            }

                            const ctx = $('#checkinChart')[0].getContext('2d');

                            // Nếu biểu đồ đã tồn tại, reset dữ liệu trước khi cập nhật
                            if (checkinChart) {
                                checkinChart.data.labels = labels;
                                checkinChart.data.datasets[0].data = values;
                                checkinChart.update();
                            } else {
                                // Tạo biểu đồ mới nếu chưa tồn tại
                                checkinChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Số lượt Check-in',
                                            data: values,
                                            borderColor: 'rgba(255, 165, 0, 1)',
                                            backgroundColor: 'rgba(255, 165, 0, 0.5)',
                                            borderWidth: 2,
                                            fill: false,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                max: Math.max(80) +
                                                    5, // Tự động điều chỉnh trục Y
                                                title: {
                                                    display: true,
                                                    text: 'Số lượt Check-in'
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Ngày'
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('#clearFilters').off('click').on('click', function() {
                $('#startDate').val('');
                $('#endDate').val('');
                $('#member').prop('checked', false);
                $('#nonMember').prop('checked', false);
                $('#below18').prop('checked', false);
                $('#above19').prop('checked', false);

            });

        });
    </script>

@endsection
