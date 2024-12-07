<?php

namespace App\Repositories;

interface PaymentMethodInterface extends RepositoryInterface
{
    public static function getAll($filter);
}
