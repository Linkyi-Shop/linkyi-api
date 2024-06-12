<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Requests\Link\CreateSocialMediaRequest;
use App\Http\Requests\Link\UpdateSocialMediaRequest;
use App\Services\SocialMediaService;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        [$proceed, $message, $data] = (new SocialMediaService())->listSocialMedia();

        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function create(CreateSocialMediaRequest $request)
    {
        [$proceed, $message, $data] = (new SocialMediaService())->createSocialMedia($request->all());
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function update(UpdateSocialMediaRequest $request, $id)
    {
        [$proceed, $message, $data] = (new SocialMediaService())->updateSocialMedia($request->all(), $id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }

    public function show($id)
    {
        [$proceed, $message, $data] = (new SocialMediaService())->getDetailSocialMedia($id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function delete($id)
    {
        [$proceed, $message, $data] = (new SocialMediaService())->deleteSocialMedia($id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
}
