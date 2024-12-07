<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface AdminInterface extends RepositoryInterface
{
    public static function getAllAdmin($filter,$role_admin);
}
