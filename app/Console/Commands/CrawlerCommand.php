<?php

namespace App\Console\Commands;

use App\Services\CrawlerService;
use Illuminate\Console\Command;

class CrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawler';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $crawler = app()->make(CrawlerService::class);

        dd($crawler->handle());
    }
}
