<?php

namespace App\Service\Scraper;

interface ScraperInterface
{
    public function scrape(): array;
}