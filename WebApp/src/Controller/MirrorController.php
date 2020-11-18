<?php

namespace App\Controller;

use App\Entity\Mirror;
use App\Entity\User;
use App\Form\AddMirrorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MirrorController extends AbstractController
{
    /**
     * @Route("/mirrors/", name="mirror_list")
     */
    public function showMirrors(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a list of mirrors without having ROLE_USER');

        $newMirror = new Mirror();
        $form = $this->createForm(AddMirrorType::class, $newMirror);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $newMirror->addManagedBy($user);
            $newMirror = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMirror);
            $this->addFlash('success', 'Nouvea mirroir ajoute!');
            $entityManager->flush();
            return $this->redirectToRoute('mirror_list');
        }

        return $this->render('mirror/list.html.twig', [
            'controller_name' => 'MirrorController',
            'addMirrorForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mirrors/{mirror_id}", name="mirror_controls")
     */
    public function index($mirror_id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a  mirror\'s controls without having ROLE_USER');

        $user = $this->getUser();
        $mirror = $this->getDoctrine()
            ->getRepository(Mirror::class)
            ->find($mirror_id);

        if ($mirror == null) {
            $this->addFlash('error', 'Ce mirroir n\'existe pas.');
            return $this->redirectToRoute('mirror_list');
        }

        $authorized = false;
        foreach ($mirror->getManagedBy() as $manager) {
            if ($manager->getId() == $user->getId()) {
                $authorized = true;
            }
        }

        if (!$mirror) {
            throw $this->createNotFoundException(
                'No mirror found for id ' . $mirror_id
            );
        }

        if ($authorized) {
            return $this->render('mirror/index.html.twig', [
                'controller_name' => 'MirrorController',
                'mirror' => $mirror,
            ]);
        } else {
            $this->addFlash('error', 'Ce mirroir ne vous appartient pas!');
            return $this->redirectToRoute('mirror_list');
        }
    }
}
