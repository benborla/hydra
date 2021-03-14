<?php

namespace Benborla\Hydra\Http\Controllers;

use App\Http\Controllers\Controller;
use Benborla\Hydra\Services\GeneratePermission;
use Spatie\Permission\Models\Permission;
use ArtisanSdk\CQRS\Dispatcher;
use Benborla\Hydra\Query\DiscoverHydraPackage;

class UpdatePermissionsAction extends Controller
{
    public function __invoke(GeneratePermission $generatePermission)
    {
        abort_if(! auth()->user()->hasAuthorityToSyncPermissions, 403);

        return $generatePermission->sync();
    }

    public function test()
    {
        dump(domain());
        dump(current_channel()->id);
        dd('--end--');
    }
}
