<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImgBBService
{
    /**
     * Upload an image to ImgBB.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null The display URL of the uploaded image or null on failure.
     */
    public static function upload($file)
    {
        $apiKey = env('IMGBB_API_KEY');

        if (!$apiKey) {
            Log::error('ImgBB API Key is not set in .env file.');
            return null;
        }

        try {
            $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload', [
                'key' => $apiKey,
                'image' => base64_encode(file_get_contents($file->getRealPath())),
            ]);

            if ($response->successful()) {
                return $response->json()['data']['url'];
            }

            Log::error('ImgBB Upload Failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('ImgBB Upload Exception: ' . $e->getMessage());
            return null;
        }
    }
}
