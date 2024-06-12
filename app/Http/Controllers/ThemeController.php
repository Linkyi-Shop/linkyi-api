<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Services\ThemeService;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        if (!$limit = request()->limit) {
            $limit = 10;
        }
        [$proceed, $message, $data] = (new ThemeService())->listThemeWithPagination($limit);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
    public function apply($id)
    {
        [$proceed, $message, $data] = (new ThemeService())->applyTheme($id);
        if (!$proceed) {
            return ResponseJson::failedResponse($message, $data);
        }
        return ResponseJson::successResponse($message, $data);
    }
}
