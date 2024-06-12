<?php

namespace App\Services;

use App\Models\BioLink;
use App\Models\BioLinkViews;
use App\Models\BioLinkVisitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BioLinkService
{
    public function listBioLinkWithPagination($limit)
    {
        try {
            $user = Auth()->user();
            $data = tap(
                BioLink::where('store_id', $user->store->id)->orderBy('sequence', 'desc')
                    ->paginate($limit),
                function ($paginatedInstance) {
                    return $paginatedInstance
                        ->getCollection()
                        ->transform(function ($item) {

                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                                'type' => $item->type,
                                'link' => $item->link,
                                'thumbnail' => $item->thumbnail,
                                'sequence' => $item->sequence,
                                'is_active' => ($item->is_active == 1),
                            ];
                        });
                }
            );



            $data->withPath($limit);

            $response = [
                'links' => $data
            ];
            return [true, 'List Bio Links', $response];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now', []];
        }
    }

    public function createBioLink($data)
    {
        try {
            DB::beginTransaction();
            $user = Auth()->user();

            $sequence = BioLink::where(['store_id' => $user->store->id])->count();

            if ($data['type'] == BioLink::TYPE_HEADLINE) {
                $data['link'] = null;
            }
            BioLink::create([
                'store_id' => $user->store->id,
                'name' => $data['name'],
                'link' => $data['link'],
                'type' => $data['type'],
                'sequence' => $sequence + 1,

            ]);
            DB::commit();
            return [true, 'Link berhasil tambahkan', []];
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
    public function updateBioLink($data, $id)
    {
        try {
            $user = Auth()->user();

            $bioLink = BioLink::where(['id' => $id, 'store_id' => $user->store->id])->first();

            if (!$bioLink) {
                return [false, "Link tidak ditemukan", []];
            }

            if ($bioLink->type == BioLink::TYPE_HEADLINE) {
                $data['link'] = null;
            }
            $bioLink->update([
                'name' => $data['name'],
                'link' => $data['link'],
            ]);

            return [true, 'Link berhasil diperbaharui', []];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
    public function deleteBioLink($id)
    {
        try {
            $user = Auth()->user();

            $bioLink = BioLink::where(['id' => $id, 'store_id' => $user->store->id])->first();

            if (!$bioLink) {
                return [false, "Link tidak ditemukan", []];
            }

            //>habus total klik
            BioLinkViews::where(['store_id' => $user->store->id, 'bio_link_id' => $id])->delete();
            //> hapus visitor
            $bioLinkVisitors = BioLinkVisitor::where(['store_id' => $user->store->id, 'bio_link_id' => $id])->get();
            foreach ($bioLinkVisitors as $item) {
                $item->storeVisitor->delete();
                $item->delete();
            }
            $bioLink->delete();

            return [true, 'Link berhasil dihapus', []];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
    public function getDetailBioLink($id)
    {
        try {
            $user = Auth()->user();

            $data = BioLink::where('store_id', $user->store->id)->find($id);

            if (!$data) {
                return [false, 'Data tidak ditemukan', []];
            }
            $response = [
                'id' => $data->id,
                'name' => $data->name,
                'link' => $data->link,
                'thumbnail' => $data->thumbnail,
                'type' => $data->type,
                'is_active' => ($data->is_active == 1),

            ];
            return [true, 'Detail link', $response];
        } catch (\Throwable $exception) {
            Log::error($exception);
            return [false, 'Server is busy right now!', []];
        }
    }
}
