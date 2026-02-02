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
        $apiKey = config('services.imgbb.key');

        if (!$apiKey) {
            Log::error('ImgBB API Key is not set in config/services.php or .env file.');
            return null;
        }

        try {
            $response = Http::withoutVerifying() // Bypass SSL verification for environments with outdated CA bundles
                ->timeout(60) // Increase timeout for slower uploads
                ->asMultipart()
                ->attach(
                    'image', 
                    file_get_contents($file->getRealPath()), 
                    $file->getClientOriginalName()
                )->post('https://api.imgbb.com/1/upload', [
                    'key' => $apiKey,
                ]);

            if ($response->successful()) {
                $url = $response->json()['data']['url'] ?? null;
                if ($url) {
                    Log::info('ImgBB Upload Success: ' . $url);
                    return $url;
                }
                Log::error('ImgBB Upload Success but no URL found: ' . $response->body());
                return null;
            }

            Log::error('ImgBB Upload Failed | Status: ' . $response->status() . ' | Response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('ImgBB Upload Exception | Message: ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString());
            return null;
        }
    }
}
