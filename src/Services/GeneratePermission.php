<?php

namespace Benborla\Hydra\Services;

use Benborla\Hydra\Services\ModelService;
use Benborla\Hydra\Models\Permission;
use ArtisanSdk\CQRS\Dispatcher;
use Benborla\Hydra\Commands\PersistPermissions;

final class GeneratePermission
{
    protected $models = [];
    protected $permissions = [];

    public function __construct(ModelService $modelService)
    {
        $this->models = $modelService->getModelNames(true);
    }

    public function sync()
    {
        return Dispatcher::make()
            ->command(PersistPermissions::class)
            ->permissions($this->generatedPermissions())
            ->run();
    }

    /**
     * @return array
     */
    private function generatedPermissions()
    {
        foreach ($this->models as $model) {
            foreach ($this->actions() as $action) {
                $permissions[] = "$model.$action";
            }
        }

        return \array_merge($permissions, Permission::getDefaultPermissions());
    }

    /**
     * actions
     *
     * @access private
     * @return void
     */
    private function actions()
    {
        return [
            Permission::CREATE,
            Permission::UPDATE,
            Permission::DELETE,
            Permission::VIEW,
            Permission::VIEW_COLLECTION,
        ];
    }
}
