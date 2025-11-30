<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(private PropertyRepository $repository)
    {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $properties = $this->repository->findLatest();
        return $this->render('home/index.html.twig', [
            'properties' => $properties
        ]);
    }
}