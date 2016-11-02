<?php

namespace Inventory\Admin\Services;

use Inventory\Admin\Models\User;

/**
 * Class UserService.
 */
class UserService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var LdapService
     */
    protected $ldap;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param User                  $user
     * @param SentryService         $sentry
     * @param LdapService           $ldap
     * @param ConfigService         $config
     */
    public function __construct(
        User $user,
        SentryService $sentry,
        LdapService $ldap,
        ConfigService $config
    ) {
        $this->model = $user;
        $this->sentry = $sentry;
        $this->ldap = $ldap;
        $this->config = $config;
    }

    /**
     * Returns a filtered and paginated collection of users.
     *
     * @return mixed
     */
    public function getByPageWithFilter()
    {
        return $this->model
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->username($this->getInput('username'))
            ->email($this->getInput('email'))
            ->paginate(25);
    }

    /**
     * Creates a user through sentry.
     *
     * @return bool|mixed
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $activated = $this->getInput('activated');

            $insert = [
                'username' => $this->getInput('username'),
                'email' => $this->getInput('email'),
                'password' => $this->getInput('password'),
                'permissions' => $this->getInput('permissions', []),
                'activated' => ($activated ? true : false),
            ];

            $record = $this->sentry->createUser($insert);

            /*
             * Due to sentry restrictions, we'll update
             * the additional user information manually
             */
            $modelRecord = $this->model->find($record->id);

            $insertAdditional = [
                'first_name' => $this->getInput('first_name'),
                'last_name' => $this->getInput('last_name'),
            ];

            $modelRecord->update($insertAdditional);

            if ($record) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Create or Update a User for authentication for use with ldap.
     *
     * @param array $credentials
     *
     * @return \Cartalyst\Sentry\Users\Eloquent\User
     */
    public function createOrUpdateLdapUser(array $credentials)
    {
        $loginAttribute = $this->config->setPrefix('cartalyst.sentry')->get('users.login_attribute');

        $username = $credentials[$loginAttribute];
        $password = $credentials['password'];

        /*
         * If a user is found, update their password to match active-directory
         */
        $user = $this->model->where('username', $username)->first();

        if ($user) {
            $this->sentry->updatePasswordById($user->id, $password);
        } else {
            /*
             * If a user is not found, create their web account
             */
            $ldapUser = $this->ldap->user($username);

            $fullName = explode(',', $ldapUser->name);
            $lastName = (array_key_exists(0, $fullName) ? $fullName[0] : null);
            $firstName = (array_key_exists(1, $fullName) ? $fullName[1] : null);

            $data = [
                'email' => $ldapUser->email,
                'password' => $password,
                'username' => $username,
                'last_name' => (string) $lastName,
                'first_name' => (string) $firstName,
                'activated' => 1,
            ];

            $user = $this->sentry->createUser($data, ['all_users', 'customers', 'workers']);
        }

        return $user;
    }

    /**
     * Processes updating a user.
     *
     * @param int|string $id
     *
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function update($id)
    {
        try {
            $this->dbStartTransaction();

            /*
             * Update the user through Sentry first
             */
            $this->sentry->update($id, $this->input);

            /*
             * Now we'll update the extra user details Sentry
             * doesn't manage
             */
            $user = $this->model->find($id);

            $insert = [
                'first_name' => $this->getInput('first_name'),
                'last_name' => $this->getInput('last_name'),
            ];

            if ($user->update($insert)) {
                $this->dbCommitTransaction();

                return $user;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
