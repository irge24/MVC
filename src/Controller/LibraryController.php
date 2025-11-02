<?php

namespace App\Controller;

use App\Entity\Bibliotek;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BibliotekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route("/library/create", name: "library_create", methods: ["GET", "POST"])]
    public function createBook(
        Request $request,
        ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();

        if ($request->isMethod('GET')) {
            // visa formuläret
            return $this->render('library/create.html.twig');
        }

        $data = $request->request; // hämtar data från form-fälten

        // ta in data i databas
        $book = new Bibliotek();
        $book->setTitel($request->request->get('titel'));
        $book->setISBN($request->request->get('ISBN'));
        $book->setFörfattare($request->request->get('författare'));
        $book->setBild($request->request->get('bild'));

        $entityManager->persist($book); // tell Doctrine you want to (eventually) save the Book
        $entityManager->flush();  // actually executes the queries (i.e. the INSERT query)

        return $this->render('library/create.html.twig', [
            'message' => 'Boken sparades med id ' . $book->getId(),
        ]);
    }

    #[Route('/library/show', name: 'library_show_all')]
    public function showAllBook(
        BibliotekRepository $bibliotekRepository
    ): Response {
        $books = $bibliotekRepository
            ->findAll();

        $allBooks = [];

        foreach ($books as $book) {

            $allBooks[] = 
            [
            'id' => $book->getId(), 
            'titel' => $book->getTitel(), 
            'ISBN' => $book->getISBN(),
            'författare' => $book->getFörfattare(),
            'bild' => $book->getBild() 
            ];
        }

        $data = [
            'books' => $allBooks
        ];

        return $this->render('library/show.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'show_one')]
    public function showBookById(
        BibliotekRepository $bibliotekRepository,
        int $id
    ): Response {
        $book = $bibliotekRepository
            ->find($id);

        $data = [
            'book' => $book
        ];

        return $this->render('library/show_one.html.twig', $data);
    }

    #[Route("/library/delete", name: "library_delete", methods: ["GET", "POST"])]
    public function deleteBook(
        Request $request,
        BibliotekRepository $bibliotekRepository,
        ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $books = $bibliotekRepository
            ->findAll();

        $allBooks = [];
        foreach ($books as $book) {

            $allBooks[] = 
            [
            'id' => $book->getId(), 
            'titel' => $book->getTitel(), 
            'ISBN' => $book->getISBN(),
            'författare' => $book->getFörfattare(),
            'bild' => $book->getBild() 
            ];
        }

        $data = [
            'books' => $allBooks
        ];

        if ($request->isMethod('GET')) {
            // visa formuläret
            return $this->render('library/delete.html.twig', $data);
        }

        $id = $request->request->get('id'); 
        $book = $bibliotekRepository->find($id);
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_show_all');
    }

    #[Route('/product/update/{id}/{value}', name: 'product_update')]
    public function updateProduct(
        ManagerRegistry $doctrine,
        int $id,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setValue($value);
        $entityManager->flush();

        return $this->redirectToRoute('product_show_all');
    }

# FRÅN ÖVNINGEN

    #[Route('/product/view', name: 'product_view_all')]
    public function viewAllProduct(
        ProductRepository $productRepository
    ): Response {
        $products = $productRepository->findAll();

        $data = [
            'products' => $products
        ];

        return $this->render('product/view.html.twig', $data);
    }

    #[Route('/product/view/{value}', name: 'product_view_minimum_value')]
    public function viewProductWithMinimumValue(
        ProductRepository $productRepository,
        int $value
    ): Response {
        $products = $productRepository->findByMinimumValue($value);

        $data = [
            'products' => $products
        ];

        return $this->render('product/view.html.twig', $data);
    }

    #[Route('/product/show/min/{value}', name: 'product_by_min_value')]
    public function showProductByMinimumValue(
        ProductRepository $productRepository,
        int $value
    ): Response {
        $products = $productRepository->findByMinimumValue2($value);

        return $this->json($products);
    }
}
