<?php

namespace Inventory\Admin\Services\Asset;

use Inventory\Admin\Services\SentryService;
use Inventory\Admin\Services\AttachmentService;
use Inventory\Admin\Services\BaseModelService;

/**
 * Class ImageService.
 */
class ImageService extends BaseModelService
{
    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param AssetService      $asset
     * @param AttachmentService $attachment
     * @param SentryService     $sentry
     */
    public function __construct(AssetService $asset, AttachmentService $attachment, SentryService $sentry)
    {
        $this->asset = $asset;
        $this->attachment = $attachment;
        $this->sentry = $sentry;
    }

    /**
     * Creates attachment records, attaches them to the asset images pivot table,
     * and moves the uploaded file into it's stationary position (out of the temp folder).
     *
     * @return mixed
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            // Find the asset
            $asset = $this->asset->find($this->getInput('asset_id'));

            $uploadDir = $this->getInput('file_path');

            // Check if any files have been uploaded
            $files = $this->getInput('files');

            if ($uploadDir && $files) {
                $records = [];

                // For each file, create the attachment record, and sync asset image pivot table
                foreach ($files as $file) {
                    $insert = [
                        'file_name' => $file,
                        'file_path' => $uploadDir.$file,
                        'user_id' => $this->sentry->getCurrentUserId(),
                    ];

                    // Create the attachment record
                    $image = $this->attachment->setInput($insert)->create();

                    // Attach the attachment record to the asset images
                    $asset->images()->attach($image);

                    $records[] = $image;
                }

                $this->dbCommitTransaction();

                // Return attachment record on success
                return $records;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
