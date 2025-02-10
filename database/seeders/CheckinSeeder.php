<?php

namespace Database\Seeders;

use App\Models\Checkin;
use App\Models\Member;
use App\Models\Qrcode;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CheckinSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách các member đã tạo
        $members = Member::all();
        $qrcodes = Qrcode::all();  // Lấy danh sách tất cả các QR code

        // Tạo 10 bản ghi checkin
        for ($i = 1; $i <= 10; $i++) {
            // Tạo thời gian ngẫu nhiên trong khoảng từ tháng 5 năm 2024 đến tháng 5 năm 2025
            $createdAt = Carbon::create(2024, 5, 1)->addMonths(rand(0, 12))->addDays(rand(0, 30));
            $updatedAt = $createdAt;  // Có thể là giống nhau hoặc có thể thêm điều chỉnh

            Checkin::create([
                'qrcode_id' => null,  // Lấy ngẫu nhiên một QR code hợp lệ
                'member_id' => null,  // Lấy một member ngẫu nhiên
                'role' => 1,  // Role ngẫu nhiên (0 hoặc 1)
                'fullname' => 'Người dùng ' . $i,
                'phone_number' => '01234567' . (90 + $i),  // Tạo số điện thoại giả
                'birthday' => '1990-01-0' . rand(1, 9),  // Ngày sinh ngẫu nhiên
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
