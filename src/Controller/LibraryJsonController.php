<?php

namespace App\Controller;

use App\Entity\Bibliotek;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BibliotekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibraryJsonController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route('api/library/books', name: 'library_show_all_books')]
    public function books(
        BibliotekRepository $bibliotekRepository
    ): Response {
        $books = $bibliotekRepository
            ->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('api/library/book/{isbn}', name: 'book_isbn')]
    public function bookISBN(
        BibliotekRepository $bibliotekRepository,
        string $isbn
    ): Response {
        $book = $bibliotekRepository->findOneBy(['ISBN' => $isbn]);

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
