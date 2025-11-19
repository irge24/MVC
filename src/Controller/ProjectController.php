<?php

namespace App\Controller;

use App\Entity\Bibliotek;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BibliotekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function proj(): Response
    {
        return $this->render('project/proj.html.twig');
    }

    #[Route('/proj_about', name: 'proj_about')]
    public function proj_about(): Response
    {
        return $this->render('project/proj_about.html.twig');
    }
}
