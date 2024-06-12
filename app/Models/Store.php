<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Store extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['user_id', 'name', 'slug', 'logo', 'description'];
    public $incrementing = false;

    public function getLogo()
    {
        return sprintf('https://storage.googleapis.com/%s/%s', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $this->logo);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function statusVerification(): HasOne
    {
        return $this->hasOne(StoreVerification::class, 'store_id', 'id');
    }
    public function storeTheme(): HasOne
    {
        return $this->hasOne(StoreTheme::class, 'store_id', 'id');
    }
    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'store_id', 'id')->where('is_active', 1)->orderBy('sequence', 'desc');
    }
    public function bioLinks(): HasMany
    {
        return $this->hasMany(BioLink::class, 'store_id', 'id')->where('is_active', 1)->orderBy('sequence', 'desc');
    }
    public function generateLink()
    {
        return env('WEB_HOST') . '/' . $this->slug;
    }
}
