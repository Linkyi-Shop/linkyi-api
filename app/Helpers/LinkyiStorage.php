<?php

namespace App\Helpers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Log;

class LinkyiStorage
{

    public static function uploadStoreProfile($file)
    {
        // Inisialisasi Google Cloud Storage client
        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
        ]);

        // Mendapatkan bucket
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));

        // Menentukan nama folder dan file dengan UUID
        $folder = 'store/';
        $fileName = $folder . str()->uuid() . '.' . $file->getClientOriginalExtension();

        // Mengunggah file ke bucket
        $bucket->upload(fopen($file->getRealPath(), 'r'), [
            'name' => $fileName,
        ]);

        return $fileName;
    }
    public static function uploadProductThumbnail($file)
    {
        // Inisialisasi Google Cloud Storage client
        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
        ]);

        // Mendapatkan bucket
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));

        // Menentukan nama folder dan file dengan UUID
        $folder = 'products/';
        $fileName = $folder . str()->uuid() . '.' . $file->getClientOriginalExtension();

        // Mengunggah file ke bucket
        $bucket->upload(fopen($file->getRealPath(), 'r'), [
            'name' => $fileName,
        ]);

        return $fileName;
    }
    public static function deleteProductThumbnail($filePath)
    {
        // Inisialisasi Google Cloud Storage client
        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
        ]);

        // Mendapatkan bucket
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));

        // Mendapatkan object dari bucket berdasarkan file path
        $object = $bucket->object($filePath);

        // Memeriksa apakah object ada dan menghapusnya
        if ($object->exists()) {
            Log::info(json_encode($object));
            $object->delete();
            return true;
        } else {
            return false;
        }
    }
}
