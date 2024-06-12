<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreView extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['store_id', 'total'];
    public $incrementing = false;
}
