<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Services\ProductService;
use App\Services\ProfileService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StorePageController extends Controller
{
    public function show($store, $id)
    {
        [$proceed, $message, $data] = (new StoreService())->getDetailStoreProduct($store, $id);
        if (!$proceed) {
            return ResponseJson::pageNotFoundResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function profile($store)
    {
        [$proceed, $message, $data] = (new ProfileService())->getStoreProfile($store);
        if (!$proceed) {
            return ResponseJson::pageNotFoundResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function products($store)
    {
        if (!$limit = request()->limit) {
            $limit = 10;
        }
        if (!$search = request()->search) {
            $search = null;
        }
        if (!$filter = request()->filter) {
            $filter = null;
        }

        [$proceed, $message, $data] = (new ProductService())->listStoreProductWithPagination($store, $limit, $search, $filter);

        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
}
