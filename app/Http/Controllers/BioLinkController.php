<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Requests\Link\CreateBioLinkRequest;
use App\Http\Requests\Link\UpdateBioLinkRequest;
use App\Http\Requests\Product\UpdateStatusProductRequest;
use App\Services\BioLinkService;
use Illuminate\Http\Request;

class BioLinkController extends Controller
{
    public function index()
    {
        if (!$limit = request()->limit) {
            $limit = 10;
        }
        [$proceed, $message, $data] = (new BioLinkService())->listBioLinkWithPagination($limit);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function create(CreateBioLinkRequest $request)
    {
        [$proceed, $message, $data] = (new BioLinkService())->createBioLink($request->all());
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function update(UpdateBioLinkRequest $request, $id)
    {
        [$proceed, $message, $data] = (new BioLinkService())->updateBioLink($request->all(), $id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }

    public function show($id)
    {
        [$proceed, $message, $data] = (new BioLinkService())->getDetailBioLink($id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function delete($id)
    {
        [$proceed, $message, $data] = (new BioLinkService())->deleteBioLink($id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function updateStatus(UpdateStatusProductRequest $request, $id)
    {
        [$proceed, $message, $data] = (new BioLinkService())->updateStatusBioLink($request->all(), $id);

        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
}
