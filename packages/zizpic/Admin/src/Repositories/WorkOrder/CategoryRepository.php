<?php

namespace Inventory\Admin\Repositories\WorkOrder;

use Inventory\Admin\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'work-orders';
}
