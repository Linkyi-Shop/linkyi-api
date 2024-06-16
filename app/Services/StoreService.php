<?php

namespace App\Services;

use App\Helpers\LinkyiStorage;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreService
{
    public function updateStoreProfile($data)
    {
        try {
            $user = Auth()->user();

            $store = Store::where(['user_id' => $user->id])->first();

            if (!$store) {
                return [false, "Store tidak tersedia", []];
            }
            $payload = [
                'name' => $data['name'],
                'description' => $data['description'],
            ];
            if (isset($data['logo'])) {
                LinkyiStorage::deleteObjectFile($store->logo);
                $payload['logo'] = LinkyiStorage::uploadStoreProfile($data['logo']);
            }
            $store->update($payload);

            return [true, 'Toko berhasil diperbaharui', []];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }

    public function getDetailStoreProduct($slug, $id)
    {
        $storeProfile = Store::where(['slug' => $slug])->first();

        if (!$storeProfile) {
            return [false, 'Halaman tidak ditemukan', []];
        }

        $prodcut = Product::where(['id' => $id, 'store_id' => $storeProfile->id, 'is_active' => 1])->first();
        if (!$prodcut) {
            return [false, 'Produk tidak ditemukan', []];
        }

        $response = [

            'products' => [
                'title' => $prodcut->title,
                'price' => $prodcut->price,
                'thumbnail' => $prodcut->getThumbnail(),
            ],
            'category' => [
                'name' => $prodcut->productCategory->name,
                'slug' => $prodcut->productCategory->slug,
            ],
            'links' => $prodcut->linkProducts->map(function ($item) {
                return [
                    'link' => $item->link,
                    'type' => $item->type,
                ];
            })

        ];

        return [true, 'Detail produk', $response];
    }
}
