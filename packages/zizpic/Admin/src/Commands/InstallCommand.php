<?php

namespace Zizpic\Admin\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zizpic:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the zizpic migrations';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Checking Database Schema');

        $this->call('zizpic:check-schema');

        $this->info('Running migrations');

        $this->call('zizpic:run-migrations');

        $this->info('zizpic has been successfully installed');
    }
}
