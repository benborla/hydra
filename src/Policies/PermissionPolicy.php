<?php

namespace Benborla\Hydra\Policies;

use App\Models\User;
use Illuminate\Http\Request;
use Benborla\Hydra\Policies\AbstractPolicy;

class PermissionPolicy extends AbstractPolicy
{
    protected $model = 'permission';
}
