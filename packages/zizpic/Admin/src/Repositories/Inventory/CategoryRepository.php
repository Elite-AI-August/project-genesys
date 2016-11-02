<?php

namespace Inventory\Admin\Repositories\Inventory;

use Inventory\Admin\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'inventories';
}
