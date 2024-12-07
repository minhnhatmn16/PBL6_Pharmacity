<?php

namespace App\Repositories;
interface OrderInterface extends RepositoryInterface{
    public static function getDetailOrder($id);
    public static function getAll($filter);
}