<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
            'admin_fullname' => 'Kim Tien Tran',
            'email' => 'kimtientran0410@gmail.com',
            'password' => Hash::make('123456'),
            'admin_is_admin' => 2,
            'email_verified_at'=> now()
            ],
            [
                'admin_fullname' => 'Trần Thị Tuyến',
                'email' => 'kimtien@yopmail.com',
                'password' => Hash::make('123456'),
                'admin_is_admin' => 1,
                'email_verified_at' => now()
            ],
            [
                'admin_fullname' => 'Lê Thanh Sơn',
                'email' => 'kimtien@yopmail.com',
                'password' => Hash::make('123456'),
                'admin_is_admin' => 0,
                'email_verified_at' => now()
            ],
        ];
        foreach ($admins as $admin){
            Admin::create($admin);
        }
       
    }
}
