<?php

namespace Benborla\Hydra\Services;

use Benborla\Hydra\Models\DeclaredModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

final class ModelService
{
    private const CACHE_MODEL = 'cached_models';

    public function __construct()
    {
        $this->triggerClassRegister();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModelNames(bool $toLowerCase = false)
    {
        return collect($this->getModels())
            ->map(function ($model) use ($toLowerCase) {
                $model = $toLowerCase ? \strtolower($model) : $model;
                return substr($model, strrpos($model, '\\') + 1, strlen($model));
            });
    }

    /**
     * @return void
     */
    private function triggerClassRegister()
    {
        return new DeclaredModels;
    }

    /**
     * @return null|\Illuminate\Support\Collection
     */
    private function getModels(): ?\Illuminate\Support\Collection
    {
        if ($cachedModels = Cache::get(self::CACHE_MODEL)) {
            return $cachedModels;
        }

        $models = collect(get_declared_classes())
            ->filter(function ($class) {
                return strpos($class, 'Models') !== false
                    && strpos($class, 'DeclaredModels') === false;
            })
            ->filter(function ($class) {
                $reflection = new \ReflectionClass($class);
                return $reflection->isSubclassOf(Model::class)
                    && !$reflection->isAbstract();
            });

        Cache::forever(self::CACHE_MODEL, $models);

        return $models;
    }
}
