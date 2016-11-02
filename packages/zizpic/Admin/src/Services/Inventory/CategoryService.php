<?php

namespace Inventory\Admin\Services\Inventory;

use Inventory\Admin\Models\Category;
use Inventory\Admin\Services\CategoryService as BaseCategoryService;

/**
 * Class CategoryService.
 */
class CategoryService extends BaseCategoryService
{
    /**
     * @var Category
     */
    protected $model;

    protected $scoped_id = 'inventories';

    /**
     * @param Category $inventoryCategory
     */
    public function __construct(Category $inventoryCategory)
    {
        $this->model = $inventoryCategory;
    }
}
