<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        // Sửa dấu backtick thành dấu nháy đơn hoặc kép
        $csvFile = base_path('storage/crawl_data/thuockedon/khangdiungkedon.csv');

        // Đọc file CSV
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0); // Giả sử dòng đầu tiên của file là header

        // Vòng lặp để chèn dữ liệu vào bảng products
        foreach ($csv as $row) {
            
            $productPrice = $this->processProductPrice($row['product_price']);
            $productImages = json_encode(array_map('trim',explode(',',$row['product_images'])));
            DB::table('products')->insert([
                'product_name' => $row['product_name'],
                'product_price' => $productPrice,
                'brand_id' => $row['brand_id'],
                'category_id' => $row['category_id'],
                'product_images' => $productImages,
                'product_ingredients' => $row['product_ingredients'],
                'product_uses' => $row['product_uses'],
                'place_of_manufacture' => $row['place_of_manufacture'],
                'product_package' => $row['product_package'],
                'dosage_form'=> $row['dosage_form'],
                'product_notes' => $row['product_notes'],
                'product_description' => $row['product_description'],
                'product_created_at' => now(),
                'product_updated_at' => now(),
            ]);
        }
       
    }
    private function processProductPrice($price)
    {
        // Nếu giá trị trống hoặc không hợp lệ thì trả về giá trị mặc định là 0.0
        return (!empty($price) && is_numeric($price)) ? number_format((float)$price, 1, '.', '') : '0.0';
    }
}
