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
            Log::error('ImgBB Upload Error: API Key is not set in config/services.php or .env file.');
            return null;
        }

        if (!$file->isValid()) {
            Log::error('ImgBB Upload Error: File is invalid | Error: ' . $file->getErrorMessage());
            return null;
        }

        try {
            $apiUrl = 'https://api.imgbb.com/1/upload?key=' . $apiKey;
            
            // Log attempt
            Log::info('Attempting ImgBB upload for: ' . $file->getClientOriginalName() . ' | Size: ' . $file->getSize() . ' bytes');

            $response = Http::withoutVerifying()
                ->timeout(120) // Give it more time
                ->asMultipart()
                ->attach(
                    'image', 
                    fopen($file->getRealPath(), 'r'), 
                    $file->getClientOriginalName()
                )
                ->post($apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                $url = $data['data']['url'] ?? null;
                
                if ($url) {
                    Log::info('ImgBB Upload Success: ' . $url);
                    return $url;
                }
                
                Log::error('ImgBB Upload Success but no URL in JSON: ' . json_encode($data));
                return null;
            }

            Log::error('ImgBB Upload Failed | Status: ' . $response->status() . ' | Response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('ImgBB Upload Exception | Message: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ':' . $e->getLine());
            return null;
        }
    }
}
