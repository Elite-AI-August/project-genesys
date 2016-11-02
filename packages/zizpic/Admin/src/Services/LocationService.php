<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Location;

/**
 * Class LocationService.
 */
class LocationService extends BaseNestedSetModelService
{
    public function __construct(Location $location)
    {
        $this->model = $location;
    }
}
