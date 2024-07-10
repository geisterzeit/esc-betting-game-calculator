<?php

namespace App\Service;

use App\Model\Guesser;
use App\Repository\ResultRepository;

class ResultCalculationService
{

    public function __construct(private readonly ResultRepository $resultRepository)
    {
    }

    public function calculateSortedResult(array $guessers): array
    {
        $results = [];
        foreach ($guessers as $guesser) {
            $results[$guesser->getName()] = $this->calculatePointsForGuesser($guesser);
        }
        arsort($results);
        return $results;
    }

    private function calculatePointsForGuesser(Guesser $guesser): int
    {
        $points = 0;
        foreach ($this->resultRepository->getResults() as $result) {
            $guessIsExistent = array_key_exists($result->getRunningOrder(), $guesser->guesses);

            if ($guessIsExistent) {
                $guessForCountry = $guesser->guesses[$result->getRunningOrder()];
                $guessMatchesResult = $guessForCountry == $result->getPlace();

                if ($guessMatchesResult) {
                    if ($result->getPlace() <= 3) {
                        $points += 25;
                    } else {
                        $points += 10;
                    }
                } else {
                    $deviation = abs($guessForCountry - $result->getPlace());
                    $points -= $deviation;
                }

            } else {
                $points -= 30;
            }

        }
        return $points;
    }
}