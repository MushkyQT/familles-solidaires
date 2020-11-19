<?php

namespace App\Controller;

use App\Entity\Mirror;
use App\Entity\User;
use App\Form\AddMirrorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $newMirror = $form->getData();
            $newMirror->addManagedBy($user);
            $entityManager->persist($newMirror);
            $entityManager->flush();
            $this->addFlash('success', 'Nouvea mirroir ajoute!');
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

    /**
     * @Route("/ajax/remove_mirror", name="ajax_mirror_remove", condition="request.isXmlHttpRequest()")
     */
    public function removeMirror(Request $request): Response
    {
        $mirrorToRemove = $request->request->get('mirror');
        $owner = $request->request->get('owner');
        $user = $this->getUser();

        if ($user->getId() == $owner) {
            $em = $this->getDoctrine()->getManager();
            $mirrors = $this->getDoctrine()
                ->getRepository(Mirror::class)
                ->findBy(
                    [
                        'address' => $mirrorToRemove,
                    ]
                );

            foreach ($mirrors as $mirror) {
                $managers = $mirror->getManagedBy();
                foreach ($managers as $manager) {
                    if ($manager->getId() == $owner) {
                        $em->remove($mirror);
                        $em->flush();
                        $this->addFlash('success', 'Mirroir ' . $mirror->getAddress() . ' a ete supprime');
                        return new Response(null, 204);
                    }
                }
            }

            $this->addFlash('error', "Could not find a manager with this id for this mirror.");
            return new JsonResponse(null, 401);

        } else {
            $this->addFlash('error', "Could not delete mirror as current user and mirror's owner do not match");
            return new JsonResponse(null, 400);
        }
    }
}
