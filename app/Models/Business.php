<?php

namespace App\Models;

use App\Models\Employment;
use App\Models\PayItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'external_id',
        'name',
        'enabled',
        'deduction',
    ];

    /**
     * The users that belong to the business.
     *
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'employment')->using(Employment::class);
    }

    /**
     * Get the pay items for the business.
     */
    public function payItems()
    {
        return $this->hasMany(PayItem::class);
    }

    /**
     * Get users based on the external_id value in the pivot table.
     */
    /*public function scopeByExternalId(Builder $query, string $externalId)
    {
        return $query->whereHas('users', function ($query) use ($externalId) {
            return $query->where('business_user.external_id', $externalId);
        });
    }*/
}
