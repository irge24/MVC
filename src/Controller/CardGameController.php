<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\CardHand; // Kmom03
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
    public function start(SessionInterface $session): Response
    {
        $playerHand = $session->get("player-hand") ?? new \App\Card\CardHand();
        $bankHand = $session->get("bank-hand") ?? new \App\Card\CardHand();

        $data = [
            "turn" => $session->get("turn") ?? "player",
            "player_cards" => $playerHand->getString(),
            "bank_cards" => $bankHand->getString(),
            "message" => ""
        ];

        return $this->render('start.html.twig', $data);
    }

    // Kmom03
    #[Route("/game/doc", name: "doc")]
    public function doc(): Response
    {
        return $this->render('doc.html.twig');
    }

    // Kmom03
    #[Route("/game/draw_card", name: "draw_card")]
    public function draw_card(SessionInterface $session): Response
    {
        
        // Spelare tar ett kort från kortleken
        if ($session->get("deck") === null) {
            $deckObject = new DeckOfCards();
            $deckObject->deck();
            $deckObject->shuffle();
            $session->set("deck", $deckObject->getDeck());
        }
        
        $cardDeck = $session->get("deck");
        $card = new Card();
        $result = $card->aCard($cardDeck);
        $cardString = $result[0];
        $aCard = new Card();
        $aCard->setValueString($cardString);
        $newDeck = $result[1];
        $session->set("deck", $newDeck); // uppdaterar kortleken, tar bort dragna kort

        $playerHand = $session->get("player-hand") ?? new CardHand();
        $bankHand = $session->get("bank-hand") ?? new CardHand();

        // vems tur
        $turn = $session->get("turn") ?? "player";
        if ($turn === "player") {
            $playerHand->addCard($aCard);
        } else {
            $bankHand->addCard($aCard);
        }

        $session->set("player-hand", $playerHand);
        $session->set("bank-hand", $bankHand);

        $data = [
            "aCard" => $aCard,
            "player_cards" => $playerHand->getString(),
            "bank_cards" => $bankHand->getString(),
            "turn" => $session->get("turn"),
            "message" => $message ?? "",  // tom sträng om meddelande ej finns
        ];

        return $this->render('start.html.twig', $data);
    }

    // Kmom03
    #[Route("/game/stop", name: "stop")]
    public function stop(SessionInterface $session): Response
    {
        $turn = $session->get("turn");
        $playerHand = $session->get("player-hand") ?? new \App\Card\CardHand();
        $bankHand = $session->get("bank-hand") ?? new \App\Card\CardHand();

        if ($turn == "player") {
            $session->set("turn", "bank");
        }
        else {
            $session->set("turn", "player");
        }

        if ($turn == "bank") {
            // totalt värde
            $totalPlayer = $playerHand->getTotalValue();
            $totalBank = $bankHand->getTotalValue();

            // räkna ut vinst
            if ($totalPlayer == $totalBank) {
                $message = "Banken vann!";
            } elseif ($totalBank > $totalPlayer) {
                $message = "Banken vann!";
            } elseif ($totalPlayer > 21) {
                $message = "Banken vann!";
            } elseif ($totalBank > 21) {
                $message = "Spelaren vann!";
            } else {
                $message = "(ej färdig)";
            }   
        }

        $data = [
            "turn" => $session->get("turn"),
            "player_cards" => $playerHand->getString(),
            "bank_cards" => $bankHand->getString(),
            "message" => $message ?? "",  // tom sträng om meddelande ej finns
        ];

        return $this->render('start.html.twig', $data);
    }

    // Kmom03
    #[Route("/game/new_game", name: "new_game")]
    public function new_game(SessionInterface $session): Response
    {
        // Nollställ spelet
        $session->clear();

        $data = [
            "turn" => $session->get("turn") ?? "player",  // standard: player
            "player_cards" => [],
            "bank_cards" => [],
            "message" => "Ny omgång!"
        ];

        return $this->render('start.html.twig', $data);
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
