<?php

namespace Inventory\Admin\Services\WorkOrder;

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

    /**
     * The nested set scope ID.
     *
     * @var string
     */
    protected $scoped_id = 'work_orders';

    /**
     * Constructor.
     *
     * @param Category                           $workOrderCategory
     */
    public function __construct(Category $workOrderCategory)
    {
        $this->model = $workOrderCategory;
    }
}
