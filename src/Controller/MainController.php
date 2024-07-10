<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResultCalculationService;
use App\Twig\Components\InputTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/result', name: 'result')]
    public function result(Request $request, ResultCalculationService $calculationService): Response
    {
        $decoded = InputTable::jsonToGuesserArray(base64_decode($request->query->get('guesses')));

        return $this->render('result.html.twig', [
            'results' => $calculationService->calculateSortedResult($decoded)
        ]);
    }
}
