<?php

namespace Benborla\Hydra\Resources;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;
use Benborla\Hydra\Models\Permission;
use Illuminate\Http\Request;

abstract class HydraResource extends NovaResource
{
    public static $permissionKey = 'user';

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if(
            self::isAuthorizedTo(self::getPermissionKey(), Permission::VIEW_COLLECTION)
        ) {
            return $query;
        }

        return $query->where('id', '-1');
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        if(
            self::isAuthorizedTo(self::getPermissionKey(), Permission::VIEW)
        ) {
            return parent::detailQuery($request, $query);
        }

        return $query->where('id', '-1');
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * @return \App\Models\User
     */
    protected function user(): \App\Models\User
    {
        return auth()->user();
    }

    /**
     * @return string
     */
    protected static function getPermissionKey(): string
    {
        return static::$permissionKey;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public static function availableForNavigation(Request $request): bool
    {
        return auth()->user()->hasPermissionTo(self::getPermissionKey() . '.' . Permission::VIEW_COLLECTION);
    }

    /**
     * @param string $permissionKey
     * @param string $action
     *
     * @return bool
     */
    protected static function isAuthorizedTo($permissionKey, $action): bool
    {
        return auth()->user()->hasPermissionTo("$permissionKey.$action");
    }
}
