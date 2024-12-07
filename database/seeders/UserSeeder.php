<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'user_fullname' => 'Kim Tiến',
                'email' => 'kimtien@yopmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now()
            ],
            [
                'user_fullname' => 'Minh Nhật',
                'email' => 'minhnhat@yopmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now()
            ],
            [
                'user_fullname' => 'Đình Phước',
                'email' => 'dinhphuoc@yopmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now()
            ],
            [
                'user_fullname' => 'Đình Văn',
                'email' => 'dinhvan@yopmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now()
            ],
            [
                'user_fullname' => 'Nhật Minh',
                'email' => 'nhatminh@yopmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now()
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
