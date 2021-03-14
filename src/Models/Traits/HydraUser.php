<?php

namespace Benborla\Hydra\Models\Traits;

use Benborla\Hydra\Models\UserChannel;
use Benborla\Hydra\Models\Permission;

trait HydraUser
{
    /**
     * We'll be using this logic since authorize method doesn't work
     *
     * @return bool
     */
    public function getHasAuthorityToSyncPermissionsAttribute(): bool
    {

        return $this->hasPermissionTo('permission.create') &&
            $this->hasPermissionTo('permission.update');
    }

    public function userChannels()
    {
        return $this->hasMany(UserChannel::class);
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->hasPermissionTo(Permission::IS_AUTHORIZED_TO_VIEW_MAIN_ADMIN_PANEL);
    }

    public function getIsTenantAttribute()
    {
        return false === $this->hasPermissionTo(Permission::IS_AUTHORIZED_TO_VIEW_MAIN_ADMIN_PANEL)
            && count($this->userChannels);
    }

    public function scopeHasChannel($query, $user, $channelDomain)
    {
        return $query
            ->leftJoin('user_channels', 'user_channels.user_id', '=', 'users.id')
            ->leftJoin('channels', 'channels.id', '=', 'user_channels.channel_id')
            ->leftJoin('channel_domains', 'channel_domains.channel_id', '=', 'channels.id')
            ->where('users.id', $user->id)
            ->where('channel_domains.domain', trim($channelDomain));
    }
}
