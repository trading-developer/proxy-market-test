<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property integer $id
 * @property integer $ip
 * @property integer $status
 * @property integer $provider_id
 * @property string $port
 * @property string $login
 * @property string $password
 * @property Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property Provider $provider
 */
class Proxy extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'port',
        'login',
        'password',
        'status',
        'provider_id',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActived($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
