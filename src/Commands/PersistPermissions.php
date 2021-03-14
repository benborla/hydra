<?php

namespace Benborla\Hydra\Commands;

use ArtisanSdk\CQRS\Command;
use Benborla\Hydra\Models\Permission;

class PersistPermissions extends Command
{
    public function run()
    {
        $permissions = (array) $this->argument('permissions');
        $payload = [];

        foreach ($permissions as $permission) {
            $payload[] = [
                'name' => $permission,
                'guard_name' => Permission::DEFAULT_DRIVER
            ];
        }

        return Permission::upsert($payload, 'name');
    }
}
