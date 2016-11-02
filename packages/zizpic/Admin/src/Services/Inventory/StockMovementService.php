<?php

namespace Inventory\Admin\Services\Inventory;

use Inventory\Admin\Services\ConfigService;
use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Models\InventoryStockMovement;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class StockMovementService.
 */
class StockMovementService extends BaseModelService
{
    /**
     * @var InventoryStockMovement
     */
    protected $model;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param InventoryStockMovement $inventoryStockMovement
     * @param SentryService          $sentry
     * @param ConfigService          $config
     */
    public function __construct(
        InventoryStockMovement $inventoryStockMovement,
        SentryService $sentry,
        ConfigService $config
    ) {
        $this->model = $inventoryStockMovement;
        $this->sentry = $sentry;
        $this->config = $config;
    }

    /**
     * Returns a paginated collection of the stocks model.
     *
     * @return mixed
     */
    public function getByPageWithFilter()
    {
        return $this->model
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->where('stock_id', $this->getInput('stock_id'))
            ->paginate(25);
    }

    /**
     * Creates a new inventory stock record.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'stock_id' => $this->getInput('stock_id'),
                'before' => $this->getInput('before'),
                'after' => $this->getInput('after'),
                'cost' => $this->getInput('cost'),
                'reason' => $this->getInput('reason', 'Stock Adjustment', true),
            ];

            /*
             * Only create a record if the before and after quantity differ
             * if enabled in config
             */
            if ($this->config->setPrefix('inventory')->get('allow_duplicate_movements')) {
                if ($insert['before'] != $insert['after']) {
                    $record = $this->model->create($insert);

                    $this->dbCommitTransaction();

                    return $record;
                } else {
                    /*
                     * Return true if before and after quantity are the same
                     * and prevent duplicate movements is enabled
                     */
                    return true;
                }
            } else {
                /*
                 * Prevent duplicate movements is disabled, create the record
                 */
                $record = $this->model->create($insert);

                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
