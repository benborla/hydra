<?php

namespace Benborla\Hydra\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const VIEW = 'view';
    public const VIEW_COLLECTION ='collection.view';
    public const IS_AUTHORIZED_TO_VIEW_MAIN_ADMIN_PANEL = 'user.view.main_admin_panel';

    public const DEFAULT_DRIVER = 'web';

    public static function getDefaultPermissions()
    {
        return [
            'permission.create',
            'permission.delete',
            'permission.view',
            'permission.collection.view',
            'permission.update',
            self::IS_AUTHORIZED_TO_VIEW_MAIN_ADMIN_PANEL
        ];
    }
}
