<?php

namespace Benborla\Hydra\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Benborla\Hydra\Models\Channel;

class UserChannel extends Model
{
    protected $fillable = [
        'user_id',
        'channel_id',
        'is_active'
    ];

    protected $appends = ['user', 'channel'];

    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => User::class,
        'channel_id' => Channel::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
