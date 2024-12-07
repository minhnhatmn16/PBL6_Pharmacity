<?php
namespace App\Repositories;
use App\Models\Disease;
/**
 * Interface ExampleRepository.
 */
class DiseaseRepository extends BaseRepository implements DiseaseInterface {
    public function getModel(){
        return Disease::class;
    }
    
}