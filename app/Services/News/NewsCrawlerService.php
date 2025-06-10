<?php

namespace App\Services\News;

use Goutte\Client;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class NewsCrawlerService
{
    protected $client;
    protected $keywords;

    public function __construct()
    {
        $this->client = new Client();
        $this->keywords = explode(',', env('TOPIC_KEYWORDS', 'bupati,wakil bupati,kabupaten'));
    }

    private function isMatch($text)
    {
        foreach ($this->keywords as $keyword) {
            if (Str::contains(Str::lower($text), Str::lower(trim($keyword)))) {
                return true;
            }
        }
        return false;
    }

    public function crawlDetik($limit = 5)
{
    $crawler = $this->client->request('GET', 'https://www.detik.com/');
    $data = [];

    $crawler->filter('.list-content__item')->each(function ($node) use (&$data, $limit) {
        if (count($data) >= $limit) return;

        $title = $node->filter('h3')->text();
        $link = $node->filter('a')->attr('href');

        $data[] = [
            'title' => $title,
            'url' => $link,
            'content' => null,
            'publish_date' => now(),
            'source' => 'Detik',
        ];
    });

    return $data;
}

    public function crawlKompas($limit = 5)
    {
        try {
            $crawler = $this->client->request('GET', 'https://www.kompas.com/');
            $data = [];

            $crawler->filter('.latest__wrap .latest__item')->each(function ($node) use (&$data, $limit) {
                if (count($data) >= $limit) return;

                try {
                    $title = $node->filter('.latest__title')->text();
                    $link = $node->filter('a')->attr('href');

                    if ($this->isMatch($title)) {
                        $data[] = [
                            'title' => $title,
                            'url' => $link,
                            'source' => 'Kompas',
                        ];
                    }
                } catch (\Exception $e) {
                    //
                }
            });

            return $data;
        } catch (\Exception $e) {
            Log::error("Kompas crawling failed: " . $e->getMessage());
            return [];
        }
    }

    public function crawlTempo($limit = 5)
    {
        try {
            $crawler = $this->client->request('GET', 'https://www.tempo.co/');
            $data = [];

            $crawler->filter('.terkini .card')->each(function ($node) use (&$data, $limit) {
                if (count($data) >= $limit) return;

                try {
                    $title = $node->filter('h2')->text();
                    $link = $node->filter('a')->attr('href');

                    if ($this->isMatch($title)) {
                        $data[] = [
                            'title' => $title,
                            'url' => $link,
                            'source' => 'Tempo',
                        ];
                    }
                } catch (\Exception $e) {
                    //
                }
            });

            return $data;
        } catch (\Exception $e) {
            Log::error("Tempo crawling failed: " . $e->getMessage());
            return [];
        }
    }

    public function crawlTribunnews($limit = 5)
    {
        try {
            $crawler = $this->client->request('GET', 'https://www.tribunnews.com/');
            $data = [];

            $crawler->filter('.latest-news > ul > li')->each(function ($node) use (&$data, $limit) {
                if (count($data) >= $limit) return;

                try {
                    $title = $node->filter('a')->text();
                    $link = $node->filter('a')->attr('href');

                    if ($this->isMatch($title)) {
                        $data[] = [
                            'title' => trim($title),
                            'url' => $link,
                            'source' => 'Tribunnews',
                        ];
                    }
                } catch (\Exception $e) {
                    //
                }
            });

            return $data;
        } catch (\Exception $e) {
            Log::error("Tribunnews crawling failed: " . $e->getMessage());
            return [];
        }
    }

    public function crawlRadarBekasi($limit = 5)
    {
        try {
            $crawler = $this->client->request('GET', 'https://radarbekasi.id/');
            $data = [];

            $crawler->filter('.jeg_postblock_1 .jeg_post')->each(function ($node) use (&$data, $limit) {
                if (count($data) >= $limit) return;

                try {
                    $title = $node->filter('.jeg_post_title')->text();
                    $link = $node->filter('a')->attr('href');

                    if ($this->isMatch($title)) {
                        $data[] = [
                            'title' => $title,
                            'url' => $link,
                            'source' => 'Radar Bekasi',
                        ];
                    }
                } catch (\Exception $e) {
                    //
                }
            });

            return $data;
        } catch (\Exception $e) {
            Log::error("Radar Bekasi crawling failed: " . $e->getMessage());
            return [];
        }
    }
}
