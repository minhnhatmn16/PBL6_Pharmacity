<?php 
namespace App\Repositories;
interface ImportInterface extends RepositoryInterface{
    public static function getAll($filter);
    public static function getImportDetails($id);
}