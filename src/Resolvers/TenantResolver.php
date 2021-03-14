<?php

namespace Benborla\Hydra\Resolvers;

use Benborla\Hydra\Services\HydraPackageService;
use Benborla\Hydra\Exceptions\InvalidTenantException;
use Illuminate\Support\Facades\App;

class TenantResolver
{
    public static function handle($app, HydraPackageService $hydraPackageService)
    {
        if (! is_main_admin_url()) {
            $tenant = channel()->package;

            $package = $hydraPackageService->getHydraPackage($tenant);
            $serviceProvider = $package['extra']['hydra']['providers'] ?? '';

            $serviceProvider = current($serviceProvider);

            if (! \class_exists($serviceProvider)
                || empty($serviceProvider)
            ) {
                throw new InvalidTenantException($tenant);
            }

            $app->register($serviceProvider);
        }
    }
}


