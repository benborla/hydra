<?php

namespace Benborla\Hydra\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Benborla\Hydra\Models\Channel;

class ChannelDomain extends Model
{
    protected $fillable = [
        'channel_id',
        'scheme',
        'domain'
    ];

    protected $appends = ['channel'];

    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'channel_id' => Channel::class,
    ];

    /**
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
