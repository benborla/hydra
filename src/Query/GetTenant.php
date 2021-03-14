<?php

namespace Benborla\Hydra\Query;

use ArtisanSdk\CQRS\Query;
use Benborla\Hydra\Models\Channel;

class GetTenant extends Query
{
    public function builder()
    {
        return Channel::class;
    }

    public function run()
    {
        return Channel::query()
            ->where('slug', $this->argument('channel'))
            ->where('is_active', true);
    }
}
