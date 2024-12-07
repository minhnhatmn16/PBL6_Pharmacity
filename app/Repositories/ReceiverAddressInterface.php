<?php

namespace App\Repositories;


interface ReceiverAddressInterface extends RepositoryInterface
{
    public function getAll($filter);
}