<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\Group;

/**
 * Class GroupService.
 */
class GroupService extends BaseModelService
{
    /**
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /**
     * Creates a new Sentry group.
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $insert = [
                'name' => $this->getInput('name'),
                'permissions' => $this->getInput('permissions', []),
            ];

            $record = $this->model->create($insert);

            if ($record) {
                $users = $this->getInput('users');

                if ($users) {
                    $record->users()->sync($this->getInput('users'));
                }

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Updates a sentry group.
     *
     * @param int|string $id
     *
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->model->find($id);

            $updatedPermissions = $this->getInput('permissions', []);

            /*
             * Check if the permissions current on the group exist in the updated array
             */
            foreach ($record->permissions as $permission => $allowed) {
                /*
                 * If the permission currently inside the group does not
                 * exist in the updated array, we need to add it to the array
                 * and set it to 0 to tell Sentry to remove it
                 */
                if (!array_key_exists($permission, $updatedPermissions)) {
                    $updatedPermissions[$permission] = 0;
                }
            }

            $insert = [
                'name' => $this->getInput('name'),
                'permissions' => $updatedPermissions,
            ];

            if ($record->update($insert)) {
                $record->users()->sync($this->getInput('users', []));

                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
