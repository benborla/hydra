<?php

namespace Benborla\Hydra\Http\Controllers;

use App\Http\Controllers\Controller;
use Benborla\Hydra\Services\GeneratePermission;
use Spatie\Permission\Models\Permission;

class HandleTenantChannelAction extends Controller
{
    public function __invoke(GeneratePermission $generatePermission)
    {
        dd('test');
    }
}
