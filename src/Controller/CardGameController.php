<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function home(): Response
    {
        return $this->render('card.html.twig');
    }

    // Kmom03
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game.html.twig');
    }

    // Kmom03
    #[Route("/game/start", name: "start")]
    public function start(): Response
    {
        return $this->render('start.html.twig');
    }

    #[Route("/session", name: "session")]
    public function session(): Response
    {
        return $this->render('session.html.twig');
    }

    #[Route("/session/delete", name: "session_delete")]
    public function session_delete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Nu är sessionen raderad!'
        );

        return $this->render('session.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function deck(SessionInterface $session): Response
    {

        if ($session->get("deck") === null) {
            $cardDeck = new DeckOfCards();
            $cardDeck->deck();
            $session->set("deck", $cardDeck->getDeck());
        }

        $cardDeck = $session->get("deck");

        $data = [
            "cardDeck" => $cardDeck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $cardDeck = new DeckOfCards();
        $cardDeck->shuffle();
        $cardDeck->getDeck();

        $session->set("deck", $cardDeck->getDeck());

        $data = [
            "cardDeck" => $cardDeck->getDeck()
        ];

        return $this->render('card/deck/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(SessionInterface $session): Response
    {

        $cardDeck = $session->get("deck");
        $card = new Card();
        $result = $card->aCard($cardDeck);
        $aCard = $result[0];
        $newDeck = $result[1];
        $amountCards = count($newDeck);

        $session->set("deck", $newDeck);
        $session->set("amount_cards", $amountCards);

        $data = [
            "aCard" => $aCard,
            "amountCards" => $amountCards,
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_number")]
    public function draw_number(SessionInterface $session, int $num): Response
    {

        $cardDeck = $session->get("deck");
        $amountCards = $session->get("amount_cards");
        $card = new Card();

        if ($num > $amountCards) {
            throw new \Exception("Can not choose more cards than what is left!");
        }

        $drawCards = [];
        for ($i = 1; $i <= $num; $i++) {
            $result = $card->aCard($cardDeck);
            $drawCards[] = $result[0];
            $cardDeck = $result[1];
        }

        $amountCards = count($cardDeck);
        $session->set("deck", $cardDeck);
        $session->set("amount_cards", $amountCards);

        $data = [
            "drawCards" => $drawCards,
            "amountCards" => $amountCards,
        ];

        return $this->render('card/deck/draw_number.html.twig', $data);
    }
}
