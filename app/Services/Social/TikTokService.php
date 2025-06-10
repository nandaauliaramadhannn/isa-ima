<?php

namespace App\Services\Social;

use Illuminate\Support\Facades\Http;

class TikTokService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tiktok.api_key');
    }

    public function searchVideos(string $keyword, int $limit = 10): array
    {
        $url = 'https://your-tiktok-api-provider.com/search';

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}"
        ])->get($url, [
            'keyword' => $keyword,
            'limit' => $limit,
        ]);

        if ($response->failed()) {
            return ['status' => 'error', 'message' => $response->body(), 'data' => []];
        }

        return ['status' => 'success', 'data' => $response->json()];
    }
}
