<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    public function run()
    {
        $this->upload('storage/crawl_data/table/Diseases.csv');
    }

    private function upload($file){
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0); 

        foreach ($csv as $row) {
            DB::table('diseases')->insert([
                'disease_name' => $row['disease_name'],
                'disease_thumbnail' => $row['disease_thumbnail'],
                'general_overview' => $row['general_overview'],
                'symptoms' => $row['symptoms'],
                'cause' => $row['cause'],
                'risk_subjects' => $row['risk_subjects'],
                'diagnosis' => $row['diagnosis'],
                'prevention' => $row['prevention'],
                'treatment_method' => $row['treatment_method'],
                'disease_is_delete' => 0,
                'disease_is_show' => 0,
                'disease_created_at' => now(), 
                'disease_updated_at' => now(), 
            ]);
        }
    }
}
