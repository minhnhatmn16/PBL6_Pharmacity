<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface ReviewInterface extends RepositoryInterface
{
    public static function getAll($filter);
}
