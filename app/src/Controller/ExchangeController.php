<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ExchangeController extends AbstractController
{
    #[Route('/exchange/{from}-{to}', name: 'exchange')]
    public function index($from, $to): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
