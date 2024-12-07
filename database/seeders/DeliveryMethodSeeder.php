<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "delivery_method_name" => "AT_PHARMACITY",
                "delivery_method_description" => "1-5 ngày",
                "delivery_fee" => 0
            ],
            [
                "delivery_method_name" => "SHIPPER",
                "delivery_method_description" => "5-7 ngày",
                "delivery_fee" => 25000
            ]
        ];
        foreach ($data as $index => $delivery) {
            DeliveryMethod::create($delivery);
        }
    }
}
