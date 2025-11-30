<?php

namespace App\Controller\Admin;

use App\Entity\Picture;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/picture")
 */

class AdminPictureController extends AbstractController{

    /**
     * @Route("/{id}", name="admin_picture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Picture $picture): Response
    {
        // Gérer les requêtes AJAX (JSON) et les requêtes normales (formulaire)
        $token = null;
        $isJsonRequest = false;
        
        $contentType = $request->headers->get('Content-Type', '');
        if (str_contains($contentType, 'application/json') || $request->isXmlHttpRequest()) {
            $isJsonRequest = true;
            $data = json_decode($request->getContent(), true);
            $token = $data['_token'] ?? null;
        } else {
            $token = $request->request->get('_token');
        }
        
        if (!$token) {
            if ($isJsonRequest) {
                return new JsonResponse(['error' => 'Token manquant'], 400);
            }
            $this->addFlash('error', 'Token manquant');
            return $this->redirectToRoute('admin_property_index');
        }

        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $token)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
            
            if ($isJsonRequest) {
                return new JsonResponse(['success' => 1]);
            }
            
            $this->addFlash('success', 'Image supprimée avec succès');
            return $this->redirect($request->headers->get('referer') ?: $this->generateUrl('admin_property_index'));
        }
        
        if ($isJsonRequest) {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
        
        $this->addFlash('error', 'Token invalide');
        return $this->redirectToRoute('admin_property_index');
    }

}