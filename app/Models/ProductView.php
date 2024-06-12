<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $fillable = ['id', 'store_id', 'product_id', 'views'];
}
