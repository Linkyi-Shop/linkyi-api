<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioLinkVisitor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'store_id', 'bio_link_id', 'store_visitor_id'];
    public $incrementing = false;

    public function storeVisitor()
    {
        return $this->belongsTo(StoreVisitor::class, 'store_visitor_id', 'id');
    }
}
