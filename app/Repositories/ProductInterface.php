<?php
namespace App\Repositories;

interface ProductInterface extends RepositoryInterface{
    public static function getAll($filter);
}