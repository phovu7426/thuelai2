<?php

namespace App\Repositories\Admin\Driver;

use App\Models\DriverPricingTier;
use App\Repositories\BaseRepository;

class DriverPricingTierRepository extends BaseRepository
{
    public function __construct(DriverPricingTier $driverPricingTier)
    {
        $this->model = $driverPricingTier;
    }
}


