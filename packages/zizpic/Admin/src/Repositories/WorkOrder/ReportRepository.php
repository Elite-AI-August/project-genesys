<?php

namespace Inventory\Admin\Repositories\WorkOrder;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Http\Requests\WorkOrder\ReportRequest;
use Inventory\Admin\Models\WorkOrderReport;
use Inventory\Admin\Repositories\Repository as BaseRepository;

class ReportRepository extends BaseRepository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * @return WorkOrderReport
     */
    public function model()
    {
        return new WorkOrderReport();
    }

    /**
     * Creates a new work order report.
     *
     * @param ReportRequest $request
     * @param int|string    $workOrderId
     *
     * @return bool|WorkOrderReport
     */
    public function create(ReportRequest $request, $workOrderId)
    {
        $report = $this->model();

        $report->user_id = $this->sentry->getCurrentUserId();
        $report->work_order_id = $workOrderId;
        $report->description = $request->clean($request->input('description'));

        if($report->save()) {
            return $report;
        }

        return false;
    }

    /**
     * Updates a work order report.
     *
     * @param ReportRequest $request
     * @param int|string $reportId
     *
     * @return bool|\Illuminate\Database\Eloquent\Model|null
     */
    public function update(ReportRequest $request, $reportId)
    {
        $report = $this->find($reportId);

        if($report) {
            $report->description = $request->clean($request->input('description', $report->description));

            if($report->save()) {
                return $report;
            }
        }

        return false;
    }
}
