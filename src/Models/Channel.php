<?php

namespace Benborla\Hydra\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Benborla\Hydra\Models\UserChannel;
use Benborla\Hydra\Models\ChannelDomain;


class Channel extends Model
{
    use BlameableTrait;

    protected $fillable = [
        'name',
        'slug',
        'is_active'
    ];

    /**
     * BlameableTrait configuration override
     */
    protected static $blameable = [
        'user' => \App\Models\User::class,
        'createdBy' => 'created_by',
        'updatedBy' => 'updated_by',
        'deletedBy' => 'deleted_by'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($channel) {
            $channel->slug = \Str::slug($channel->name, '-');
        });
    }

    public function userChannels()
    {
        return $this->hasMany(UserChannel::class);
    }

    public function domains()
    {
        return $this->hasMany(ChannelDomain::class);
    }

    public function scopeChannelDomain($query, $domain)
    {
        return $query->whereHas('domains', function ($subQuery) use ($domain) {
            $subQuery->where('domain', $domain);
        });
    }
}
