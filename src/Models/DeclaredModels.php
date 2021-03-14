<?php

namespace Benborla\Hydra\Models;

use Illuminate\Support\Facades\File;

/**
 * @NOTE this class' purpose is to loop all models
 * except its own self so it will be registered in
 * `get_declared_classes` function
 */
final class DeclaredModels
{
    public function __construct()
    {
        $this->__invoke();
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        $self = new \ReflectionClass($this);
        $path = \substr(
            $self->getFileName(),
            0,
            strrpos($self->getFileName(), \DIRECTORY_SEPARATOR)
        );

        $classes = collect(File::allFiles($path))
            ->filter(function ($file) {
                return strpos($file->getFileName(), 'DeclaredModels') === false
                    && strpos($file->getPathName(), 'Trait') === false;
            })
            ->map(function ($model) {
                $className = '\\' . __NAMESPACE__ . '\\' . \str_replace('.php', '', $model->getFileName());
                $instance = new $className;
            });
    }
}
