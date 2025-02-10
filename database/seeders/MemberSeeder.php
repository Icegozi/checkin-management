<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        // Tạo một member liên kết với user1
        Member::create([
            'user_id' => 3,
            'fullname' => 'Nguyễn Xuân Phúc',
            'nickname' => 'Phúc',
            'birthday' => '1990-01-01',
            'gender' => 1, // Nam
            'phone_number' => '0123456744', // Đảm bảo số điện thoại duy nhất
            'email' => 'admin1@example.com',
            'contact' => true,
            'membership_fee' => 500000.0,
            'image_use' => true,
            'address' => '123 Admin Street',
            'note' => 'Admin account',
        ]);

        
        // Tạo một member liên kết với user2
        Member::create([
            'user_id' => 3,
            'fullname' => 'Nguyễn Văn A',
            'nickname' => 'A',
            'birthday' => '1995-02-02',
            'gender' => 0, // Nữ
            'phone_number' => '0123456778', // Đảm bảo số điện thoại duy nhất
            'email' => 'staff2@example.com',
            'contact' => true,
            'membership_fee' => 500000.0,
            'image_use' => false,
            'address' => '456 Staff Avenue',
            'note' => 'Staff member',
        ]);
    }
}
