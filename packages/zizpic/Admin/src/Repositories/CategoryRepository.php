<?php

namespace Inventory\Admin\Repositories;

use Inventory\Admin\Http\Requests\CategoryRequest;
use Inventory\Admin\Models\Category;

class CategoryRepository extends Repository
{
    /**
     * The belongs to scoped attribute for
     * multiple nested sets on one table.
     *
     * @var string
     */
    protected $belongsTo = '';

    /**
     * @return Category
     */
    public function model()
    {
        return new Category();
    }

    /**
     * Retrieves a category by it's ID.
     *
     * @param int|string $id
     *
     * @return Category
     */
    public function find($id)
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * Returns the scoped categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->model()->where('belongs_to', $this->belongsTo)->get();
    }

    /**
     * Creates a new category.
     *
     * @param CategoryRequest $request
     * @param int|string      $id
     *
     * @return bool|Category
     */
    public function create(CategoryRequest $request, $id = null)
    {
        $category = $this->model();

        $category->belongs_to = $this->belongsTo;
        $category->name = $request->input('name');

        if($category->save()) {

            if(! is_null($id)) {
                $parent = $this->find($id);

                if($parent) {
                    $category->makeChildOf($parent);
                }
            }

            return $category;
        }

        return false;
    }

    /**
     * Updates a category.
     *
     * @param CategoryRequest $request
     * @param int|string      id
     *
     * @return bool|Category
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->find($id);

        if($category) {
            $category->name = $request->input('name', $category->name);

            if($category->save()) {
                return $category;
            }
        }

        return false;
    }
}
