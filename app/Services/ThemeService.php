<?php

namespace App\Services;

use App\Models\StoreTheme;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThemeService
{
    public function listThemeWithPagination($limit)
    {
        try {
            $data = tap(
                Theme::where('is_active', 1)->latest()
                    ->paginate($limit),
                function ($paginatedInstance) {
                    return $paginatedInstance
                        ->getCollection()
                        ->transform(function ($item) {
                            $user = Auth()->user();

                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                                'link' => $item->link,
                                'price' => $item->price,
                                'is_premium' => ($item->is_premium == 1),
                                'is_apply' => ($user->store->storeTheme->theme_id == $item->id)
                            ];
                        });
                }
            );



            $data->withPath($limit);

            $response = [
                'links' => $data
            ];
            return [true, 'List theme', $response];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now', []];
        }
    }

    public function applyTheme($id)
    {
        try {
            DB::beginTransaction();
            $user = Auth()->user();

            //> get theme
            $theme = Theme::where(['id' => $id, 'is_active' => 1])->first();

            if (!$theme) {
                return [false, "Tema tidak tersedia", []];
            }
            //> apply theme
            if ($theme->is_premium) {
                //> create transaksi
                return [false, "Tema premium belum tersedia", []];
            } else {
                $storeTheme = StoreTheme::where(['store_id' => $user->store->id])->first();
                $storeTheme->update(['theme_id' => $theme->id]);
            }


            DB::commit();
            return [true, 'Tema berhasil diterapkan', []];
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
}
