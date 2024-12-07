<?php

namespace App\Services;

use App\Repositories\ImportDetailInterface;

class ImportDetailService
{
    protected ImportDetailInterface $importDetailRepository;
    public function __construct(ImportDetailInterface $importDetailRepository)
    {
        $this->importDetailRepository = $importDetailRepository;
    }
}
