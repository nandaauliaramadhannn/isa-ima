<?php

namespace App\Http\Controllers;

use App\Models\Ima;
use App\Models\ImaAnalisis;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\News\NewsCrawlerService;

class NewsCrawlController extends Controller
{
    protected $crawler;

    public function __construct(NewsCrawlerService $crawler)
    {
        $this->crawler = $crawler;
    }

    public function crawlAll(Request $request)
    {
        try {
            $keyword = $request->keyword ?? env('DEFAULT_KEYWORD', 'bupati');
            $startDate = $request->tanggal_mulai ?? now()->toDateString();
            $endDate = $request->tanggal_selesai ?? now()->toDateString();

            $sources = [
                'Detik' => $this->crawler->crawlDetik(),
                'Kompas' => $this->crawler->crawlKompas(),
                'Tempo' => $this->crawler->crawlTempo(),
                'Tribunnews' => $this->crawler->crawlTribunnews(),
                'RadarBekasi' => $this->crawler->crawlRadarBekasi(),
                'PemkabBekasi' => $this->crawler->crawlPemkabBekasi(),
            ];

            $saved = 0;

            foreach ($sources as $sourceName => $articles) {
                $ima = Ima::create([
                    'sumber_media' => $sourceName,
                    'keyword' => $keyword,
                    'tanggal_mulai' => $startDate,
                    'tanggal_selesai' => $endDate,
                    'jumlah_berita' => count($articles),
                    'created_by' => auth()->id() ?? 1,
                ]);

                foreach ($articles as $article) {
                    ImaAnalisis::create([
                        'ima_id' => $ima->id,
                        'judul' => $article['title'],
                        'isi' => $article['content'] ?? '',
                        'sentimen' => 'netral', // default, bisa dianalisis nanti
                        'tanggal_publish' => $article['publish_date'] ?? now(),
                        'sumber_berita' => $sourceName,
                    ]);
                    $saved++;
                }
            }

            return response()->json([
                'status' => 'success',
                'total_saved' => $saved,
            ]);
        } catch (\Exception $e) {
            Log::error('Crawl Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Crawling gagal. Silakan cek log.',
            ], 500);
        }
    }
}
