<?php

namespace Inventory\Admin\Repositories\Inventory;

use Inventory\Admin\Http\Requests\Inventory\Stock\PutRequest;
use Inventory\Admin\Http\Requests\Inventory\Stock\TakeRequest;
use Inventory\Admin\Http\Requests\Inventory\Stock\Request;
use Inventory\Admin\Repositories\Inventory\Repository as InventoryRepository;
use Inventory\Admin\Models\InventoryStock;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class StockRepository extends BaseRepository
{
    /**
     * @var Repository
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param Repository $inventory
     */
    public function __construct(InventoryRepository $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @return InventoryStock
     */
    public function model()
    {
        return new InventoryStock();
    }

    /**
     * Creates a new inventory stock.
     *
     * @param Request      $request
     * @param int|string   $inventoryId
     *
     * @return bool|InventoryStock
     */
    public function create(Request $request, $inventoryId)
    {
        $stock = $this->model();

        $stock->inventory_id = $inventoryId;
        $stock->location_id = $request->input('location_id');
        $stock->quantity = $request->input('quantity');
        $stock->reason = $request->input('reason');
        $stock->cost = $request->input('cost');

        if($stock->save()) {
            return $stock;
        }

        return false;
    }

    /**
     * Updates an inventory stock record.
     *
     * @param Request      $request
     * @param int|string   $inventoryId
     * @param int|string   $stockId
     *
     * @return bool|InventoryStock
     */
    public function update(Request $request, $inventoryId, $stockId)
    {
        $stock = $this->find($stockId);

        if($stock) {
            /*
             * Only allow modification if the inventory
             * ID matches the stocks inventory ID.
             */
            if($stock->inventory_id === $inventoryId) {
                $stock->location_id = $request->input('location_id', $stock->location_id);
                $stock->quantity = $request->input('quantity', $stock->quantity);
                $stock->reason = $request->input('reason');
                $stock->cost = $request->input('cost');

                if($stock->save()) {
                    return $stock;
                }
            }
        }

        return false;
    }

    /**
     * Takes quantity from the specified stock.
     *
     * @param TakeRequest $request
     * @param int|string  $stockId
     *
     * @return bool|InventoryStock
     */
    public function take(TakeRequest $request, $stockId)
    {
        $stock = $this->find($stockId);

        if($stock) {
            if($stock->take($request->input('quantity'))) {
                return $stock;
            }
        }

        return false;
    }

    /**
     * Puts quantity into the specified stock.
     *
     * @param PutRequest $request
     * @param int|string $stockId
     *
     * @return bool|InventoryStock
     */
    public function put(PutRequest $request, $stockId)
    {
        $stock = $this->find($stockId);

        if($stock) {
            if($stock->put($request->input('quantity'))) {
                return $stock;
            }
        }

        return false;
    }
}
