<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuppliersSeeder extends Seeder
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
                'supplier_name' => 'Pharmaceutical Manufacturers',
                'contact_person' => 'Trần Thị Kim Tiến',
                'supplier_phone' => '0394042011',
                'supplier_email' => 'manu@yopmail.com',
                'supplier_address' => 'Đà Nẵng'
            ],
            [
                'supplier_name' => 'Pharmaceutical Distributors',
                'contact_person' => 'Trần Thị Tuyến',
                'supplier_phone' => '0398022143',
                'supplier_email' => 'dist@yopmail.com',
                'supplier_address' => 'Hà Nội'
            ],
            [
                'supplier_name' => 'Pharmaceutical Importers',
                'contact_person' => 'Lê Thanh Sơn',
                'supplier_phone' => '0987654321',
                'supplier_email' => 'impo@yopmail.com',
                'supplier_address' => 'TP Hồ Chí Minh'
            ],
            [
                'supplier_name' => 'Pharmacies',
                'contact_person' => 'Trần Cảnh Cua',
                'supplier_phone' => '0345678912',
                'supplier_email' => 'pharm@yopmail.com',
                'supplier_address' => 'Gia Lai'
            ]
        ];
        foreach($data as $supplier){
            Supplier::create($supplier);
        }
    }
}
