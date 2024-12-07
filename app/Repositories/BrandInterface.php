<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface BrandInterface extends RepositoryInterface {
    public static function getAll($filter); 
}
