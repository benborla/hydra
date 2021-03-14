<?php

namespace Benborla\Hydra\Services;

use Illuminate\Support\Facades\Cache;
use Benborla\Hydra\Exceptions\InvalidTenantException;

class HydraPackageService
{
    private const PACKAGE_HYDRA = 'hydra-package';

    public function getHydraPackage(string $package)
    {
        if ($packageInfo = Cache::get($package)) {
            return Cache::get($package);
        }

        $tenant = $package;

        $packageInfo = $this->getHydraPackages()->filter(function ($package) use ($tenant) {
            $packageInfo = current($package);
            return $packageInfo['name'] === $tenant;
        })->first()[$tenant] ?? null;

        if ( ! isset($packageInfo['extra']['hydra']['providers'])
            || is_null($packageInfo)
        ) {
            throw new InvalidTenantException($tenant);
        }

        Cache::forever($package, $packageInfo);

        return $packageInfo;

    }

    /**
     * getHydraPackages
     *
     * @access private
     * @return Collection
     */
    private function getHydraPackages()
    {
        if ($hydraPackages = Cache::get($this->getCacheDomain())) {
            return Cache::get($this->getCacheDomain());
        }

        $installed = app_path() . '/../vendor/composer/installed.json';

        if (false === file_exists($installed)) {
            return null;
        }

        $installed = \json_decode(\file_get_contents($installed), true);
        $hydraPackages = collect($installed['packages'])
            ->filter(function ($package) {
                if ($package['type'] === self::PACKAGE_HYDRA) {
                    return $package;
                }
            })
            ->map(function ($package) {
                $namespace = current(array_keys($package['autoload']['psr-4']));
                return [
                    $package['name'] => $package
                ];
            });

        Cache::forever($this->getCacheDomain(), $hydraPackages);

        return $hydraPackages;
    }

    /**
     * @return string
     */
    private function getCacheDomain()
    {
        return 'cached_hydra_packages';
    }
}
