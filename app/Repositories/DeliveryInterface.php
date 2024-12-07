<?php

namespace App\Repositories;

interface DeliveryInterface extends RepositoryInterface
{
    public static function getAll($filter);
}
