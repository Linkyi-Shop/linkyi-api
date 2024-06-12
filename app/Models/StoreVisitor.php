<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVisitor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'store_id', 'platform', 'device', 'ip', 'province', 'city', 'user_agent'];
    public $incrementing = false;
}
