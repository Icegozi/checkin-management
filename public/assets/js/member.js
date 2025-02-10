$(document).ready(function () {
    // Đồng bộ giá trị của #tit với #searchName
    $('#searchName').on('input changet', function () {
        $('#tit').val($(this).val());
    });

    $('#extend').on('click', function () {
        let selectedMembers = $('input[name="member_id"]:checked')
            .map(function () {
                return $(this).val();
            })
            .get();

        let extendValue = $('#extend_value').val();

        if (selectedMembers.length === 0) {
            alert('Vui lòng chọn ít nhất một hội viên để gia hạn.');
            return;
        }

        if (!extendValue) {
            alert('Vui lòng chọn thời gian gia hạn.');
            return;
        }

        $.ajax({
            url: '/member/extend',
            method: 'POST',
            data: {
                member_ids: selectedMembers,
                extend_value: extendValue,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
            },
            success: function (response) {
                if (response.success) {
                    alert('Gia hạn thành công.');
                    location.reload(); 
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Không thể xử lý yêu cầu. Vui lòng thử lại.');
            }
        });
    });

    function bindEvents() {
        // Hiển thị thông tin hội viên khi nhấn nút "Xem"
        $('.showMember').off('click').on('click', function () {
            let memberId = $(this).closest('tr').data('id');

            $.ajax({
                url: `/member/${memberId}`,
                type: 'GET',
                success: function (response) {
                    // let assetUrl = "{{ asset('storage') }}";
                    let link = assetUrl + "/qrcodes/" + response.qr_code + ".png";

                    $('img.qr-image').attr('src', link);
                    $('#memberCode').html(response.qr_code || 'No QR Code');
                    $('#memberName').html(response.fullname);
                    $('#notificationDiv').show();
                    $('#overlay').show();
                },
                error: function (xhr, status, error) {
                    console.error("Lỗi khi lấy thông tin hội viên: ", error);
                }
            });
        });

        $('.deleteMember').off('click').on('click', function (e) {
            e.preventDefault(); 

            let memberId = $(this).closest('tr').data('id'); 
            console.log(memberId);
            

            if (confirm('Bạn có chắc chắn muốn xóa thành viên này?')) {
                $.ajax({
                    url: `/member/delete/${memberId}`, 
                    type: 'DELETE', 
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function (response) {
                        alert(response.message || 'Xóa thành công');
                        $(`tr[data-id="${memberId}"]`).remove(); 
                    },
                    error: function (xhr, status, error) {
                        console.error("Lỗi khi xóa: ", error);
                        alert('Đã xảy ra lỗi khi xóa. Vui lòng thử lại!');
                    }
                });
            }
        });

        // Đóng modal khi bấm Cancel hoặc Overlay
        $('#cancelButton').off('click').on('click', function () {
            $('#notificationDiv').hide();
            $('#overlay').hide();
        });

        $('#overlay').off('click').on('click', function () {
            $('#notificationDiv').hide();
            $('#overlay').hide();
        });

        $('#printButton').off('click').on('click', function () {
            const memberInfo = {
                maHoiVien: $('#memberCode').text(),
                hoTen: $('#memberName').text(),
                maQR: $('.qr-image').attr('src')
            };
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            const imgWidth = 100;
            const imgHeight = 100;
            const pageWidth = doc.internal.pageSize.width;
            const pageHeight = doc.internal.pageSize.height;
            const x = (pageWidth - imgWidth) / 2;
            const y = (pageHeight - imgHeight) / 2;
            doc.addImage(memberInfo.maQR, 'PNG', x, y, imgWidth, imgHeight);
            let a = `${memberInfo.maHoiVien}_${memberInfo.hoTen}.pdf`;
            doc.save(a);
        });

    }

    // AJAX Search
    $('#searchName').on('input', function () {
        let searchName = $(this).val();
        $.ajax({
            url: "/member/search",
            type: "GET",
            data: {
                searchName: searchName
            },
            success: function (response) {
                let tableBody = $('tbody');
                tableBody.empty();

                if (response.length > 0) {
                    response.forEach(function (member) {
                        let qrCode = member.qrcodes.length > 0 ?
                            `<a href="#">${member.qrcodes[0].code}</a>` :
                            '<span>No QR Code</span>';
                        let validity = member.qrcodes.length > 0 ?
                            `${new Date(member.qrcodes[0].created_at).toISOString().slice(0, 19).replace('T', ' ')} ~ ${new Date(member.qrcodes[0].expried_time).toISOString().slice(0, 19).replace('T', ' ')}` :
                            '<span>No Expiry</span>';
                        let role = member.users ? (member.users.role == 1 ?
                            'Admin' : 'Staff') : '<span>No User</span>';

                        let row = `
                        <tr data-id="${member.id}">
                            <td class="text-center">           
                                <input type="checkbox" id="member_id" name="member_id" value="${member.id}">
                            </td>
                            <td>${qrCode}</td>
                            <td>${member.fullname}</td>
                            <td>${member.nickname}</td>
                            <td>${validity}</td>
                            <td>${member.address}</td>
                            <td>${member.phone_number}</td>
                            <td>${member.email}</td>
                            <td>${role}</td>
                            <td>
                                <a href="#" class="btn btn-lg showMember"><i class="fa-regular fa-eye"></i></a>
                                <button class="btn btn-lg deleteMember"><i class="fa-solid fa-trash-can"></i></button>

                            </td>
                        </tr>`;
                        tableBody.append(row);
                    });
                } else {
                    tableBody.append(
                        '<tr><td colspan="10" class="text-center">Không tìm thấy thành viên nào</td></tr>'
                    );
                }
                // Gán lại sự kiện sau khi cập nhật nội dung bảng
                bindEvents();
            },
            error: function (xhr, status, error) {
                console.error("Lỗi tìm kiếm: ", error);
            }
        });
    });


    // Nút Clear
    $('#clear').on('click', function () {
        $('#searchName').val('');
        $('#searchName').trigger('input');
    });

    // Gán sự kiện ban đầu
    bindEvents();
});

