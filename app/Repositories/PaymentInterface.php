<?php

namespace App\Repositories;

interface PaymentInterface extends RepositoryInterface
{
    public static function getAll($filter);
}
