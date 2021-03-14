<?php

namespace Benborla\Hydra\Query;

use ArtisanSdk\CQRS\Query;
use Benborla\Hydra\Services\HydraPackageService;

class DiscoverHydraPackage extends Query
{
    protected $hydraPackageService;

    public function __construct(HydraPackageService $hydraPackageService)
    {
        $this->hydraPackageService = $hydraPackageService;
    }

    public function builder()
    {
        return;
    }

    /**
     * @access public
     * @return Collection
     */
    public function run()
    {
        return $this->hydraPackageService->getHydraPackages();
    }

}
