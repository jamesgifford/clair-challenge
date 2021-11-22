<?php

namespace App\Models;

use App\Models\Business;
use App\Models\Employment;
use App\Models\PayItem;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The businesses that belong to the user.
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'employment')->using(Employment::class);
    }

    /**
     * Get the pay items for the user.
     */
    public function payItems()
    {
        return $this->hasMany(PayItem::class);
    }

    /**
     * The businesses that belong to the user.
     */
    public function employment(string $externalId)
    {
        return $this->belongsToMany(Business::class)->withPivot('external_id')->wherePivot('external_id', $externalId)->first();
    }

    /**
     * Get businesses based on the external_id value in the pivot table.
     */
    /*public function scopeByExternalId(Builder $query, string $externalId)
    {
        return $query->whereHas('businesses', function ($query) use ($externalId) {
            return $query->where('business_user.external_id', $externalId);
        });
    }*/
}
