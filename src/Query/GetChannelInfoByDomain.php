<?php

namespace Benborla\Hydra\Query;

use ArtisanSdk\CQRS\Query;
use Benborla\Hydra\Models\Channel;

final class GetChannelInfoByDomain extends Query
{
    public function builder()
    {
        return Channel::class;
    }

    public function run()
    {
        return Channel::query()
            ->channelDomain($this->argument('domain'));
    }
}
