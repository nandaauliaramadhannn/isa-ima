<?php

namespace App\Services\Social;

use Illuminate\Support\Facades\Http;

class InstagramService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = config('services.instagram.access_token');
    }

    public function getUserMedia(string $userId): array
    {
        $url = "https://graph.instagram.com/{$userId}/media";

        $response = Http::get($url, [
            'access_token' => $this->accessToken,
            'fields' => 'id,caption,media_url,permalink,timestamp',
        ]);

        if ($response->failed()) {
            return ['status' => 'error', 'message' => $response->body(), 'data' => []];
        }

        return ['status' => 'success', 'data' => $response->json()];
    }
}
