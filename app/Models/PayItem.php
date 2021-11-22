<?php

namespace App\Models;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'business_id',
        'external_id',
        'amount',
        'pay_rate',
        'hours',
        'paid_at',
    ];

    /**
     * Get the user that owns the pay item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the business that owns the pay item.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
