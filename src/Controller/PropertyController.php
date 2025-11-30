<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    public function __construct(private PropertyRepository $repository)
    {
    }

    #[Route('/properties', name: 'app_properties')]
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    #[Route('/properties/{id}', name: 'app_property_show')]
    public function show(int $id): Response
    {
        $property = $this->repository->find($id);

        if (!$property) {
            throw $this->createNotFoundException('Property not found');
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }
}
