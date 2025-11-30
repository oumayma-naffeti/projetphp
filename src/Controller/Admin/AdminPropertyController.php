<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    public function __construct(
        private PropertyRepository $repository,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/admin', name: 'admin_property_index')]
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties
        ]);
    }

    #[Route('/admin/property/create', name: 'admin_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer les images si présentes
            $pictureFiles = $form->get('pictureFiles')->getData();
            if ($pictureFiles) {
                // Convertir en tableau si ce n'est pas déjà le cas
                if (!is_array($pictureFiles)) {
                    $pictureFiles = [$pictureFiles];
                }
                $property->setPictureFiles($pictureFiles);
            }
            
            $this->entityManager->persist($property);
            $this->entityManager->flush();
            
            $this->addFlash('success', 'Bien créé avec succès');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/new.html.twig', [
            'form' => $form->createView(),
            'property' => $property
        ]);
    }
#[Route('/admin/property/{id}/edit', name: 'admin_property_edit')]
public function edit(Property $property, Request $request, EntityManagerInterface $em)
{
    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'Bien modifié avec succès');
        return $this->redirectToRoute('admin_property_index');
    }

    return $this->render('admin/property/edit.html.twig', [
        'form' => $form->createView(),
        'property' => $property
    ]);
}

    #[Route('/admin/property/{id}', name: 'admin_property_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('admin_property_index');
    }
}
