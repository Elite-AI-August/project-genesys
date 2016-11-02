<?php

namespace Inventory\Admin\Services\Asset;

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
    protected $scoped_id = 'assets';

    /**
     * Constructor.
     *
     * @param Category                       $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }
}
