<?php

namespace App\Twig\Components;

use App\Model\Guesser;
use App\Repository\ResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class InputTable extends AbstractController
{
    use DefaultActionTrait;

    public array $results = [];
    #[LiveProp(writable: true, hydrateWith: 'jsonToGuesserArray', dehydrateWith: 'guesserArrayToJson')]
    public array $guessers = [];
    #[LiveProp(writable: true)]
    public string $newGuesserName = "";

    public function __construct(private readonly ResultRepository $resultRepository)
    {
        $this->results = $resultRepository->getResults();
    }

    public static function jsonToGuesserArray($data): array
    {
        $decoded = [];
        foreach (json_decode($data, true) as $encoded) {
            $guesser = Guesser::fromJson($encoded);
            $decoded[$guesser->id] = $guesser;
        }
        return $decoded;
    }

    #[LiveAction]
    public function addGuesser()
    {
        if (!empty($this->newGuesserName)) {
            $newGuesser = new Guesser($this->newGuesserName);
            $this->guessers[$newGuesser->getId()] = $newGuesser;
            $this->newGuesserName = "";
        }
    }

    #[LiveAction]
    public function updateGuess(#[LiveArg] string $guesserId, #[LiveArg] string $country, #[LiveArg] int $guess)
    {
        $this->getGuesserById($guesserId)->guesses[$country] = $guess;
    }

    private function getGuesserById(string $id): Guesser
    {
        return $this->guessers[$id];
    }

    #[LiveAction]
    public function calculateResults()
    {
        return $this->redirectToRoute('result', ['guesses' => base64_encode($this->guesserArrayToJson($this->guessers))]);
    }

    public static function guesserArrayToJson(array $guessers): string
    {
        return json_encode($guessers);
    }
}