<?php

// Modifierar DiceGameController från övningen -> CardGameController

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
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
        $cardDeck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValue($i);
            $cardDeck[] = $card->getAsString();
        }

        $session->set("deck", $cardDeck);

        $data = [
            "cardDeck" => $cardDeck,
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $cardDeck = [];
        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->setValue($i);
            $cardDeck[] = $card->getAsString();
        }

        shuffle($cardDeck);

        $session->set("deck", $cardDeck);

        $data = [
            "cardDeck" => $cardDeck
        ];

        return $this->render('card/deck/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(SessionInterface $session): Response
    {

        $cardDeck = $session->get("deck");
        $aCard = array_shift($cardDeck);
        $newDeck = $cardDeck;
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

        if ($num > $amountCards) {
            throw new \Exception("Can not choose more cards than what is left!");
        }

        $drawCards = [];
        for ($i = 1; $i <= $num; $i++) {
            $aCard = array_shift($cardDeck);
            $drawCards[] = $aCard;
            $newDeck = $cardDeck;
        }

        $amountCards = count($newDeck);
        $session->set("deck", $newDeck);
        $session->set("amount_cards", $amountCards);

        $data = [
            "drawCards" => $drawCards,
            "amountCards" => $amountCards,
        ];

        return $this->render('card/deck/draw_number.html.twig', $data);
    }

// PIG GAME

    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }


    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $numDice = $request->request->get('num_dices');

        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        $hand->roll();

        $session->set("pig_dicehand", $hand);
        $session->set("pig_dices", $numDice);
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);

        return $this->redirectToRoute('pig_play');
    }


    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response
    {
        $dicehand = $session->get("pig_dicehand");

        $data = [
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString() 
        ];

        return $this->render('pig/play.html.twig', $data);
    }

    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response
    {
        $hand = $session->get("pig_dicehand");
        $hand->roll();

        $roundTotal = $session->get("pig_round");
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );
                $round = 0;
                $roundTotal = 0;
                break;
            }
            $round += $value;
        }

        $session->set("pig_round", $roundTotal + $round);
        
        return $this->redirectToRoute('pig_play');
    }

    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response
    {
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        $session->set("pig_round", 0);
        $session->set("pig_total", $roundTotal + $gameTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('pig_play');
    }
}