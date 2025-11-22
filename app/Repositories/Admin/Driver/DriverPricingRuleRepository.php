<?php

namespace App\Repositories\Admin\Driver;

use App\Models\DriverPricingRule;
use App\Repositories\BaseRepository;

class DriverPricingRuleRepository extends BaseRepository
{
    public function __construct(DriverPricingRule $driverPricingRule)
    {
        $this->model = $driverPricingRule;
    }
}


