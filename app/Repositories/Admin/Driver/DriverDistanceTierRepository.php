<?php

namespace App\Repositories\Admin\Driver;

use App\Models\DriverDistanceTier;
use App\Repositories\BaseRepository;

class DriverDistanceTierRepository extends BaseRepository
{
    public function __construct(DriverDistanceTier $driverDistanceTier)
    {
        $this->model = $driverDistanceTier;
    }
}


