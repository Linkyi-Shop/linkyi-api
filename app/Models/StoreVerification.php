<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVerification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'store_id', 'status'];
    public $incrementing = false;

    const STATUS_PENDING = 'pending';
    const STATUS_UNVERIFIED = 'unverified';
    const STATUS_VERIFIED = 'verified';
}
