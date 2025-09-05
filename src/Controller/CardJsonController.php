<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardJsonController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function deck(): Response
    {
        $cardDeck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValue($i);
            $cardDeck[] = $card->getAsString();
        }

        $response = new JsonResponse($cardDeck);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle", methods: ['POST'])]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck->getDeck());

        return $this->json([
            'deck' => $deck->getDeck()
        ]);
    }

    #[Route("/api/deck/draw", name: "api_draw", methods: ['POST'])]
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get("deck", []);
        $card = new Card();
        [$aCard, $newDeck] = $card->aCard($deck);

        $session->set("deck", $newDeck);

        return $this->json([
            'drawn_card' => $aCard,
            'amount' => count($newDeck)
        ]);
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_draw_number", methods: ['POST'])]
    public function draw_number(SessionInterface $session, int $num): Response
    {
        $deck = $session->get("deck", []);
        $card = new Card();

        if ($num > count($deck)) {
            return $this->json(['error' => 'Not enough cards left'], 400);
        }

        $drawnCards = [];
        for ($i = 0; $i < $num; $i++) {
            [$aCard, $deck] = $card->aCard($deck);
            $drawnCards[] = $aCard;
        }

        $session->set("deck", $deck);

        return $this->json([
            'drawn_cards' => $drawnCards,
            'amount' => count($deck)
        ]);
    }
}
