<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Category;

class CategoryService extends BaseNestedSetModelService
{
    protected $scoped_id = '';

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Retrieves all categories scoped.
     *
     * @param array $select
     *
     * @return mixed
     */
    public function get($select = ['*'])
    {
        return $this->model->select($select)->where('belongs_to', $this->scoped_id)->get();
    }

    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'name' => $this->getInput('name'),
                'belongs_to' => $this->scoped_id,
            ];

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }
}
