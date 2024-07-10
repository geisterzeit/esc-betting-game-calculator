<?php

namespace App\Model;

class CountryResult
{
    public function __construct(
        private readonly int    $runningOrder,
        private readonly int    $place,
        private readonly string $countryName,
        private readonly string $artist,
        private readonly string $song
    )
    {
    }

    public static function fromCsvLine(array $csvLine): CountryResult
    {
        return new CountryResult($csvLine[0], $csvLine[1], $csvLine[2], $csvLine[3], $csvLine[4]);
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function getSong(): string
    {
        return $this->song;
    }

    public function getPlace(): int
    {
        return $this->place;
    }

    public function getRunningOrder(): int
    {
        return $this->runningOrder;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function __toString(): string
    {
        return $this->countryName;
    }
}