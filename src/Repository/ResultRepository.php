<?php

namespace App\Repository;

use App\Model\CountryResult;

class ResultRepository
{
    /**
     * @var CountryResult[]
     */
    private array $results;

    public function __construct()
    {
        $csvFilePath = '../src/Resources/results-2024.csv';
        $file = fopen($csvFilePath, "r");

        while (!feof($file)) {
            $this->results[] = CountryResult::fromCsvLine(fgetcsv($file));
        }
    }

    public function getResults(): array
    {
        return $this->results;
    }
}