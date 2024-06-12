<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioLink extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $fillable = ['id', 'store_id', 'link', 'name', 'thumbnail', 'sequence', 'type', 'is_active'];
    const TYPE_LINK = 'link';
    const TYPE_HEADLINE = 'headline';
}
