<?php

namespace App\Services\Social;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = config('services.facebook.access_token');
    }

    public function getPagePosts(string $pageId): array
    {
        $url = "https://graph.facebook.com/{$pageId}/posts";

        $response = Http::get($url, [
            'access_token' => $this->accessToken,
            'fields' => 'message,created_time,permalink_url',
        ]);

        if ($response->failed()) {
            return ['status' => 'error', 'message' => $response->body(), 'data' => []];
        }

        return ['status' => 'success', 'data' => $response->json()];
    }
}
