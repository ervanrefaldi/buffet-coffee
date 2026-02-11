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
        $apiKey = config('services.imgbb.key') ?? env('IMGBB_API_KEY');

        if (!$apiKey) {
            Log::error('ImgBB Upload Error: API Key is missing. Check .env or config/services.php');
            return null;
        }

        if (!$file || !$file->isValid()) {
            Log::error('ImgBB Upload Error: File is invalid or missing.');
            return null;
        }

        try {
            Log::info('Attempting ImgBB upload (Base64 method) for: ' . $file->getClientOriginalName());

            // Using Base64 method which is more robust
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->asForm()
                ->post('https://api.imgbb.com/1/upload', [
                    'key'   => $apiKey,
                    'image' => base64_encode(file_get_contents($file->getRealPath())),
                    'name'  => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                ]);

            if ($response->successful()) {
                $url = $response->json()['data']['url'] ?? null;
                if ($url) {
                    Log::info('ImgBB Upload Success: ' . $url);
                    return $url;
                }
                Log::error('ImgBB Upload Success but no URL in response: ' . $response->body());
                return null;
            }

            // Log detailed response for debugging
            Log::error('ImgBB Upload Failed | Status: ' . $response->status());
            Log::error('ImgBB Response Body: ' . $response->body());
            
            return null;

        } catch (\Exception $e) {
            Log::error('ImgBB Exception: ' . $e->getMessage());
            return null;
        }
    }
}
