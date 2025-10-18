<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route("/api/quote", name: "api_quote")]
    public function quote(): Response
    {

        $data = [
            'quote1' => 'Be happy, be positive.',
            'quote2' => 'Every situation is what you make out of it.',
            'quote3' => 'Be strong!'
        ];

        $randomQuote = array_rand($data, 1);

        $date = date("l jS \of F Y h:i:s A");

        $responseData = [
            'date' => $date,
            'quote' => $data[$randomQuote]
        ];

        $response = new JsonResponse($responseData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
