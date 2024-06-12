<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Requests\Product\CreateProductLinkRequest;
use App\Http\Requests\Product\UpdateProductLinkRequest;
use App\Services\ProductService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class LinkProductController extends Controller
{

    public function create(CreateProductLinkRequest $request, $id)
    {
        [$proceed, $message, $data] = (new ProductService())->cretaeProductLink($request->all(), $id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function update(UpdateProductLinkRequest $request, $id, $link)
    {
        [$proceed, $message, $data] = (new ProductService())->updateProductLink($request->all(), $id, $link);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function delete($id, $link)
    {
        [$proceed, $message, $data] = (new ProductService())->deleteProductLink($id, $link);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
}
