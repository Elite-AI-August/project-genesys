<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Note;

/**
 * Class NoteService.
 */
class NoteService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param Note          $note
     * @param SentryService $sentry
     */
    public function __construct(Note $note, SentryService $sentry)
    {
        $this->model = $note;

        $this->sentry = $sentry;
    }

    /**
     * Creates a note.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'content' => $this->getInput('content', null, true),
            ];

            $record = $this->model->create($insert);

            if ($record) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
