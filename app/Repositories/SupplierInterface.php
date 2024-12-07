<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface SupplierInterface extends RepositoryInterface
{
    public static function getAll($filter);
}
