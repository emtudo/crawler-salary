<?php

namespace App\Services;

use App\Events\CrawlerEvent;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class CrawlerService
{
    protected $client;
    protected $crawler;
    protected $table;
    protected $salaries = [];
    protected $url;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->client = new Client();

        $guzzleClient = new GuzzleClient([
            'timeout' => 60,
            'verify' => false,
        ]);

        $this->client->setClient($guzzleClient);
    }

    public function handle()
    {
        $this->crawler = $this->client->request('GET', $this->url);

        $this->setTable()
            ->setSalaries();

        return $this->salaries;
    }

    public function setTable()
    {
        $this->table = $this->crawler->filter('table')->each(function ($node) {
            if ('border-collapse: collapse; margin: 0px; padding: 0px;' === $node->attr('style')) {
                return $node;
            }
        })[0] ?? null;

        return $this;
    }

    public function setSalaries()
    {
        $data = $this->table->filter('tr')->each(function ($tr) {
            return [
                'vigencia' => str_replace(["\n", "\t", " "], "", $tr->filter('td')->first()->text()),
                'valor_mensal' => str_replace(["\n", " "], "", $tr->filter('td')->eq(1)->text())
            ];
        });

        unset($data[0]);

        $this->salaries = $data;

        return $this;
    }
}
