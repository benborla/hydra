<?php

namespace Benborla\Hydra;

use Laravel\Nova\Nova;
use Laravel\Nova\ResourceTool;
use Benborla\Hydra\Resources\Tenant;

class Hydra extends ResourceTool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            Tenant::class
        ]);
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Hydra';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'hydra';
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        // return view('hydra::navigation');
    }
}
