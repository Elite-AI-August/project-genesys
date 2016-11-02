<?php

namespace Inventory\Admin\Validators\Inventory;

use Inventory\Admin\Services\Inventory\StockService;
use Illuminate\Support\Facades\Route;

/**
 * Class StockLocationValidator.
 */
class StockLocationValidator
{
    /**
     * @var StockService
     */
    protected $inventoryStock;

    /**
     * Constructor.
     *
     * @param StockService $inventoryStock
     */
    public function __construct(StockService $inventoryStock)
    {
        $this->inventoryStock = $inventoryStock;
    }

    /**
     * Validates that a stock does not exist on the specified location.
     *
     * @param string     $attribute
     * @param int|string $locationId
     * @param array      $parameters
     *
     * @return bool
     */
    public function validateStockLocation($attribute, $locationId, $parameters)
    {
        $itemId = Route::getCurrentRoute()->getParameter('inventory');
        $stockId = Route::getCurrentRoute()->getParameter('stocks');

        if (!empty($stockId)) {
            $stocks = $this->inventoryStock
                ->where('inventory_id', $itemId)
                ->where('id', '!=', $stockId)
                ->where('location_id', $locationId)
                ->get();
        } else {
            $stocks = $this->inventoryStock
                ->where('inventory_id', $itemId)
                ->where('location_id', $locationId)
                ->get();
        }

        if ($stocks->count() > 0) {
            return false;
        }

        return true;
    }
}
