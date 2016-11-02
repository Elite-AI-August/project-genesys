<?php

namespace Inventory\Admin\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Cartalyst\DataGrid\Laravel\Facades\DataGrid;

abstract class Repository
{
    /**
     * The repositories model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Returns the current model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function model();

    /**
     * Finds the specified record by it's ID.
     *
     * @param int|string $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
         return $this->model()->findOrFail($id);
    }

    /**
     * Deletes a record on the current model.
     *
     * @param int|string $id
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete($id)
    {
        return $this->model()->destroy($id);
    }

    /**
     * Retrieves all of the current users inventory items.
     *
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model();

        return $this->newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Constructs a new data grid instance with the
     * specified resource, columns and settings.
     *
     * @param mixed    $data
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function newGrid($data, array $columns = [], array $settings = [], $transformer = null)
    {
        return DataGrid::make($data, $columns, $settings, $transformer);
    }

    /**
     * Caches an item with the specified key and value.
     *
     * @param int|string $key
     * @param int        $minutes
     * @param \Closure   $closure
     *
     * @return mixed
     */
    public function cache($key, $minutes = 60, \Closure $closure)
    {
        return Cache::remember($key, $minutes, $closure);
    }

    /**
     * Caches an item with the
     * specified key and value forever.
     *
     * @param int|string $key
     * @param \Closure   $closure
     *
     * @return mixed
     */
    public function cacheForever($key, $closure)
    {
        return Cache::rememberForever($key, $closure);
    }

    /**
     * Returns true / false if the cache
     * contains an item with the specified key.
     *
     * @param int|string $key
     *
     * @return bool
     */
    public function cacheHas($key)
    {
        return Cache::has($key);
    }

    /**
     * Returns true / false if the key
     * specified has been forgotten in the cache.
     *
     * @param int|string $key
     *
     * @return bool
     */
    public function cacheForget($key)
    {
        return Cache::forget($key);
    }

    /**
     * Starts a database transaction
     */
    protected function dbStartTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * Commits the current database transaction
     */
    protected function dbCommitTransaction()
    {
        DB::commit();
    }

    /**
     * Rolls back a database transaction
     */
    protected function dbRollbackTransaction()
    {
        DB::rollback();
    }

    /**
     * Converts a string to a date for inserting into the database.
     *
     * @param string $str
     *
     * @return bool|string
     */
    protected function strToDate($str)
    {
        return date('Y-m-d H:i:s', strtotime($str));
    }
}
