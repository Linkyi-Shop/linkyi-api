<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioLinkViews extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['id', 'store_id', 'bio_link_id', 'total'];
    public $incrementing = false;
}
