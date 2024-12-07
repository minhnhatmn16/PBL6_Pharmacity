<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorysSeeder extends Seeder
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
                'category_name' => 'thuốc',
                'category_parent_id' => null,
                'category_type' => 'medicine',
            ],
            [
                'category_name' => 'Tra cứu bệnh',
                'category_parent_id' => null,
                'category_type' => 'disease',
            ],
            // [
            //     'category_name' => 'Thuốc không kê đơn',
            //     'category_parent_id' => 1,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240223191727-0-P00126_5.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc kê đơn',
            //     'category_parent_id' => 1,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240223191446-0-P00218_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc ngừa thai',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225125105-0-P02182_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc kháng dị ứng',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225125000-0-P25114_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc kháng viêm',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225124924-0-P01421_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc cảm lạnh',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225125105-0-P02182_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc giảm cân',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225125105-0-P02182_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc Mắt/Tai/Mũi',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225124455-0-P00057_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc tiêu hoá',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225124403-0-P20205.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc dành cho nam',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225124135-0-P04392_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Giảm đau, hạ sốt',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225124009-0-P00126_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc da liễu',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225123914-0-P00589_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc dành cho phụ nữ',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225123756-0-P01250_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc thần kinh',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225124009-0-P00126_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc cơ xương khớp',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225123622-0-P10601_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Dầu gió, dầu cù là..',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225123332-0-P00117_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc khác',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225123231-0-P14604_3.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Vitamin & Khoáng chất',
            //     'category_parent_id' => 3,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225123113-0-P00053_1.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc tiểu đường',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121824-0-P01655_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc cho nam giới',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225120950-0-P01337_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Vitamin và Khoáng chất',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121141-0-P13193_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc da liễu KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121326-0-P00218_1_l%20%281%29.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc dành cho nữ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121416-0-P01911_1_l%20%281%29.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc cảm lạnh và ho',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121509-0-P00116_6.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc ngừa thai KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121552-0-P00203_2.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc tim mạch, huyết áp',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121635-0-P04379_2.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc kháng sinh',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121740-0-P14179_2_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc tiêu hoá KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122559-0-P00214_2.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc kháng dị ứng KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225121919-0-P00456_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Sản phẩm khác',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122006-0-P04921_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc kháng viêm KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122145-0-P01027_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc khác KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122232-0-P04921_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc thần kinh KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122316-0-P02486_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc giảm đau, hạ sốt KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122356-0-P00259_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Hệ hô hấp',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122438-0-P11166_1_l.png',
            //     'category_type' => 'medicine',
            // ],
            // [
            //     'category_name' => 'Thuốc cơ xương khớp KĐ',
            //     'category_parent_id' => 4,
            //     'category_thumbnail' => 'https://prod-cdn.pharmacity.io/e-com/images/ecommerce/300x300/20240225122519-0-P13313_1_l.png',
            //     'category_type' => 'medicine',
            // ]

        ];
        foreach($data as $index => $category){
            Category::create($category);
        }
    }
}
