<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTheme extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'store_id', 'theme_id', 'expired', 'type'];
    public $incrementing = false;

    const TYPE_PREMIUM = 'premium';
    const TYPE_FREE = 'free';
    const TYPE_TRIAL = 'trial';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expired' => 'date',
        'type' => 'string',  // Enum type can be cast to string or handled separately as required.
    ];
}
