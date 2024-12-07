<?php

namespace App\Repositories;

interface DeliveryMethodInterface extends RepositoryInterface
{
    public static function getAll($filter);
}
