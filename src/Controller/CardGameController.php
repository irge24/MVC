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
        /** @var CardHand $playerHand */
        $playerHand = $session->get("player-hand") ?? new \App\Card\CardHand();

        /** @var CardHand $bankHand */
        $bankHand = $session->get("bank-hand") ?? new \App\Card\CardHand();

        $session->set("turn", "player");

        $data = [
            "turn" => "player",
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
    public function drawCard(SessionInterface $session): Response
    {

        $message = "";

        // nytt kortspel ifall det inte finns
        if ($session->get("deck") === null) {
            $deckObject = new DeckOfCards();
            $deckObject->deck();
            $deckObject->shuffle();
            $session->set("deck", $deckObject->getDeck());
        }

        // spelare tar ett kort, tas bort från föregående kortspel
        /** @var array<string> $cardDeck */
        $cardDeck = $session->get("deck");
        $card = new Card();
        $result = $card->aCard($cardDeck);
        $cardString = $result[0];
        $aCard = new Card();
        $aCard->setValueString((string)$cardString);
        $newDeck = $result[1];
        $session->set("deck", $newDeck); // uppdaterar kortleken

        // spelarens och bankens respektive kort, spelaren drar nya kort

        /** @var CardHand $playerHand */
        $playerHand = $session->get("player-hand") ?? new CardHand();

        /** @var CardHand $bankHand */
        $bankHand = $session->get("bank-hand") ?? new CardHand();
        $playerHand->addCard($aCard);

        $session->set("player-hand", $playerHand);
        $session->set("bank-hand", $bankHand);

        $data = [
            "aCard" => $aCard,
            "player_cards" => $playerHand->getString(),
            "bank_cards" => $bankHand->getString(),
            "turn" => $session->get("turn"),
            "player_total" => $playerHand->getTotalValue(),
            "bank_total" => $bankHand->getTotalValue(),
            "message" => $message
        ];

        return $this->render('start.html.twig', $data);
    }

    // Kmom03
    #[Route("/game/stop", name: "stop")]
    public function stop(SessionInterface $session): Response
    {

        /** @var CardHand $playerHand */
        $playerHand = $session->get("player-hand");

        /** @var CardHand $bankHand */
        $bankHand = $session->get("bank-hand") ?? new \App\Card\CardHand();
        
        $turn = $session->get("turn");
        $totalBank = $bankHand->getTotalValue();
        $totalPlayer = $playerHand->getTotalValue();

        if ($turn == "player") {
            $session->set("turn", "bank");
        }

        while ($totalBank < 17) {

            /** @var array<string> $cardDeck */
            $cardDeck = $session->get("deck");
            $card = new Card();
            $result = $card->aCard($cardDeck);
            $cardString = $result[0];
            $aCard = new Card();
            $aCard->setValueString((string)$cardString);
            $newDeck = $result[1];

            $bankHand->addCard($aCard);

            $session->set("bank-hand", $bankHand);
            $session->set("deck", $newDeck); // uppdaterar kortleken
            $totalBank = $bankHand->getTotalValue();
        }

        // Räkna ut vinnare
        $message = $this->winner($playerHand, $bankHand);

        $data = [
            "turn" => $session->get("turn"),
            "player_cards" => $playerHand->getString(),
            "bank_cards" => $bankHand->getString(),
            "player_total" => $playerHand->getTotalValue(),
            "bank_total" => $bankHand->getTotalValue(),
            "message" => $message
        ];

        return $this->render('start.html.twig', $data);
    }
    
    private function winner(CardHand $playerHand, CardHand $bankHand): string
    {
        $totalPlayer = $playerHand->getTotalValue();
        $totalBank = $bankHand->getTotalValue();

        $perfectScore = 21;

        if ($totalPlayer > $perfectScore) {
            return "Banken vann!";
        } elseif ($totalBank > $perfectScore) {
            return "Spelaren vann!";
        } elseif ($totalBank >= $totalPlayer) {
            return "Banken vann!";
        } else {
            return "Spelaren vann!";
        }
    }

    // Kmom03
    #[Route("/game/new_game", name: "new_game")]
    public function newGame(SessionInterface $session): Response
    {
        // Nollställ spelet
        $session->clear();
        $session->set("turn", "player");

        $data = [
            "turn" => "player",
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
    public function sessionDelete(SessionInterface $session): Response
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

        /** @var array<string> $cardDeck */
        $cardDeck = $session->get("deck");

        $data = [
            "cardDeck" => $cardDeck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deckObject = new DeckOfCards();
        $deckObject->shuffle();
        $cardDeck = $deckObject->getDeck();

        $session->set("deck", $cardDeck);

        $data = [
            "cardDeck" => $cardDeck
        ];

        return $this->render('card/deck/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(SessionInterface $session): Response
    {

        /** @var array<string> $cardDeck */
        $cardDeck = $session->get("deck");
        $card = new Card();
        $result = $card->aCard($cardDeck);
        $aCard = $result[0];
        $newDeck = $result[1];

        /** @var array<string> $newDeck */
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
    public function drawNumber(SessionInterface $session, int $num): Response
    {

        /** @var array<string> $cardDeck */
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
