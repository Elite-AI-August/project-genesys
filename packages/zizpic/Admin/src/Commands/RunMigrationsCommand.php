<?php

namespace Zizpic\Admin\Commands;

use Illuminate\Console\Command;

class RunMigrationsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zizpic:run-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the zizpic migrations';

    /**
     * Execute the command.
     */
    public function fire()
    {
        $this->call('migrate', [
            '--path' => 'packages/zizpic/Admin/src/migrations',
        ]);
    }
}
 