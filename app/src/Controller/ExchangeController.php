<?php

namespace App\Controller;

use App\Exception\InvalidClientExpection;
use App\Model\ExchangeModel;
use App\Service\ExchangeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ExchangeController extends AbstractController
{
    public const EXCHANGE_CLIENTS = [
        'ExchangeRate'
    ];
    private ExchangeService $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }


    #[Route('/exchange/{client}/{from}-{to}', name: 'exchange')]
    public function index(string $from, string $to, string $client, Request $request): Response
    {
        if (!in_array($client, self::EXCHANGE_CLIENTS)) {
            throw new InvalidClientExpection('Client is not supported', Response::HTTP_BAD_REQUEST);
        }

        $exchangeModel = new ExchangeModel($from, $to, $request->get('amount'));
        $response = $this->exchangeService->getExchangeRate($exchangeModel);

        return new JsonResponse($response);
    }
}
