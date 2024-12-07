<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
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
                "payment_method_name" => "COD"
            ],
            [
                "payment_method_name" => "PAYOS"
            ],
        ];
        foreach ($data as $payment) {
            PaymentMethod::create($payment);
        }
    }
    
}
