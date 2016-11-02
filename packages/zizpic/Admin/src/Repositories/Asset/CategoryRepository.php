<?php

namespace Inventory\Admin\Repositories\Asset;

use Inventory\Admin\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'assets';
}
