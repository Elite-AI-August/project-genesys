<?php

namespace Inventory\Admin\Services;

use Stevebauman\CoreHelper\Services\ConfigService as CoreHelperConfigService;

/**
 * Class ConfigService.
 */
class ConfigService extends CoreHelperConfigService
{
    /**
     * Updates the maintenance site configuration file.
     *
     * @return bool
     */
    public function updateSite()
    {
        /*
         * Set the site configuration path
         */
        $siteConfig = 'maintenance/site.php';

        $content = $this->getConfigFile($siteConfig);

        $content = $this->replaceConfigEntry($content, 'main', 'maintenance.site.title.main', $this->getInput('title'));
        $content = $this->replaceConfigEntry($content, 'admin', 'maintenance.site.title.admin', $this->getInput('admin_title'));
        $content = $this->replaceConfigEntry($content, 'work-orders', 'maintenance.site.calendars.work-orders', $this->getInput('work_order_calendar'));
        $content = $this->replaceConfigEntry($content, 'inventories', 'maintenance.site.calendars.inventories', $this->getInput('inventory_calendar'));
        $content = $this->replaceConfigEntry($content, 'assets', 'maintenance.site.calendars.assets', $this->getInput('asset_calendar'));

        /*
         * Put the updated content back inside
         * the config file and return the result
         */
        return $this->setConfigFile($siteConfig, $content);
    }

    /**
     * Updates the laravel mail configuration file.
     *
     * @return bool
     */
    public function updateMail()
    {
        /*
         * Set the mail configuration file path
         */
        $mailConfig = 'mail.php';

        /*
         * Get the content from the configuration file
         */
        $content = $this->getConfigFile($mailConfig);

        /*
         * Replace configuration entries inside the config content
         */
        $content = $this->replaceConfigEntry($content, 'driver', 'mail.driver', $this->getInput('mail_driver'));
        $content = $this->replaceConfigEntry($content, 'username', 'mail.username', $this->getInput('smtp_username'));

        /*
         * Since we can't pre-populate the password field we need to make sure
         * that we default the config password to it's current so it's
         * not overwritten with a blank field
         */
        $content = $this->replaceConfigEntry($content, 'password', 'mail.password',
            ($this->getInput('smtp_password') ? $this->getInput('smtp_password') : $this->get('mail.password'))
        );

        $content = $this->replaceConfigEntry($content, 'host', 'mail.host', $this->getInput('host_ip'));
        $content = $this->replaceConfigEntry($content, 'port', 'mail.port', $this->getInput('host_port'), 'integer');
        $content = $this->replaceConfigEntry($content, 'address', 'mail.from.address', $this->getInput('global_email'));
        $content = $this->replaceConfigEntry($content, 'name', 'mail.from.name', $this->getInput('global_name'));
        $content = $this->replaceConfigEntry($content, 'encryption', 'mail.encryption', $this->getInput('encryption'));

        $pretend = false;
        if ($this->getInput('pretend')) {
            $pretend = true;
        }

        $content = $this->replaceConfigEntry($content, 'pretend', 'mail.pretend', $pretend, 'bool');

        /*
         * Put the updated content back inside
         * the config file and return the result
         */
        return $this->setConfigFile($mailConfig, $content);
    }
}
