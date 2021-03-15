<?php

use Benborla\Hydra\Query\GetChannelInfoByDomain;
use ArtisanSdk\CQRS\Dispatcher;
use Illuminate\Http\Request;
use Benborla\Hydra\Models\Channel;

if (! function_exists('get_tenant')) {
    function get_tenant($domain) {

        return Dispatcher::make()
            ->query(GetChannelInfoByDomain::class)
            ->domain($domain)
            ->get()
            ->first();
    }
}

if (! function_exists('domain')) {
    function domain() {
        $fragments = explode(':', request()->root());

        return str_replace('//', '', next($fragments));
    }
}

if (! function_exists('is_valid_url')) {
    function is_valid_url() {

        if (is_main_admin_url()) {
            return true;
        }

        return (bool) channel()->id ?? false;
    }
}

if (! function_exists('is_main_admin_url')) {
    function is_main_admin_url() {
        return request()->getScheme() . '://' . domain() === config('app.url');
    }
}

if (! function_exists('channel')) {
    function channel() {
        return get_tenant(domain());
    }
}
