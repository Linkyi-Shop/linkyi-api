<?php

namespace App\Services;

use App\Helpers\LinkHelper;
use App\Models\SocialMedia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocialMediaService
{
    public function listSocialMedia()
    {
        try {
            $user = Auth()->user();
            $data = SocialMedia::where('store_id', $user->store->id)->latest()->get();
            $socialMedia = $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'link' => $item->link,
                ];
            });
            $response = [
                'social_media' => $socialMedia
            ];
            return [true, 'List social media', $response];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now', []];
        }
    }

    public function createSocialMedia($data)
    {
        try {
            DB::beginTransaction();
            $user = Auth()->user();

            SocialMedia::create([
                'store_id' => $user->store->id,
                'name' => $data['name'],
                'link' => $data['link'],
            ]);
            DB::commit();
            return [true, 'Sosial Media berhasil tambahkan', []];
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
    public function updateSocialMedia($data, $id)
    {
        try {
            $user = Auth()->user();

            $socialMedia = SocialMedia::where(['id' => $id, 'store_id' => $user->store->id])->first();

            if (!$socialMedia) {
                return [false, "Link tidak ditemukan", []];
            }
            //> validasi link
            $linkHelper = LinkHelper::extractUsernameFromUrl($data['link'], $data['name']);

            $socialMedia->update([
                'name' => $data['name'],
                'link' => $linkHelper,
            ]);

            return [true, 'Sosial media berhasil diperbaharui', []];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
    public function deleteSocialMedia($id)
    {
        try {
            $user = Auth()->user();

            $socialMedia = SocialMedia::where(['id' => $id, 'store_id' => $user->store->id])->first();

            if (!$socialMedia) {
                return [false, "Link tidak ditemukan", []];
            }

            //>habus total klik
            $socialMedia->delete();

            return [true, 'Link berhasil dihapus', []];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
    public function getDetailSocialMedia($id)
    {
        try {
            $user = Auth()->user();

            $data = SocialMedia::where('store_id', $user->store->id)->find($id);

            if (!$data) {
                return [false, 'Data tidak ditemukan', []];
            }
            $response = [
                'id' => $data->id,
                'name' => $data->name,
                'link' => $data->link,
            ];
            return [true, 'Detail sosial media', $response];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
}
