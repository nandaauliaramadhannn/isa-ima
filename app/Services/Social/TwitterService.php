<?php

namespace App\Services\Social;

use Illuminate\Support\Facades\Http;

class TwitterService
{
    protected $bearerToken;

    public function __construct()
    {
        $this->bearerToken = config('services.twitter.bearer_token');
    }

    public function searchTweets(string $query, int $limit = 10): array
    {
        $url = 'https://api.twitter.com/2/tweets/search/recent';

        $response = Http::withToken($this->bearerToken)->get($url, [
            'query' => $query,
            'max_results' => $limit,
        ]);

        if ($response->failed()) {
            return ['status' => 'error', 'message' => $response->body(), 'data' => []];
        }

        return ['status' => 'success', 'data' => $response->json()];
    }
}
