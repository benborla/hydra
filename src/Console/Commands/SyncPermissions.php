<?php

namespace Benborla\Hydra\Console\Commands;

use Illuminate\Console\Command;
use Benborla\Hydra\Services\GeneratePermission;
use Illuminate\Support\Facades\Artisan;

class SyncPermissions extends Command
{
    /** The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hydra:sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions based on new and current models';

        /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \Benborla\Hydra\Services\GeneratePermission $generatePermission
     */
    public function handle(GeneratePermission $generatePermission)
    {
        $generatePermission->sync();
        Artisan::call('cache:clear');
    }

}
