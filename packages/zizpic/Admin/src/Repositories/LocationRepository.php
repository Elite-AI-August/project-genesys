<?php

namespace Inventory\Admin\Repositories;

use Inventory\Admin\Models\Location;

class LocationRepository extends CategoryRepository
{
    protected $belongsTo = 'locations';

    /**
     * @return Location
     */
    public function model()
    {
        return new Location();
    }
}
