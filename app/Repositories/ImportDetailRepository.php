<?php

namespace App\Repositories;
use App\Models\ImportDetail;

class ImportDetailRepository extends BaseRepository implements ImportDetailInterface
{
    public function getModel()
    {
        return ImportDetail::class;
    }
}
