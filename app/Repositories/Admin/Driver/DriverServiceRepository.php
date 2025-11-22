<?php

namespace App\Repositories\Admin\Driver;

use App\Models\DriverService;
use App\Repositories\BaseRepository;

class DriverServiceRepository extends BaseRepository
{
    public function __construct(DriverService $driverService)
    {
        $this->model = $driverService;
    }
}


