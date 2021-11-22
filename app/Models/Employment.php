<?php

namespace App\Models;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Employment extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'business_id',
        'user_id',
        'external_id',
    ];

    /**
     * Get the user that owns the employment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the business that owns the employment.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
