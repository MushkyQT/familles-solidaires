<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MirrorController extends AbstractController
{
    /**
     * @Route("/mirrors/", name="mirror_list")
     */
    public function showMirrors(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a list of mirrors without having ROLE_USER');
        $mirrors = [
            '1' => '192.168.1.216'
        ];
        return $this->render('mirror/list.html.twig', [
            'controller_name' => 'MirrorController',
            'mirrors' => $mirrors,
        ]);
    }

    /**
     * @Route("/mirrors/{mirror_id}", name="mirror_controls")
     */
    public function index($mirror_id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a  mirror\'s controls without having ROLE_USER');
        return $this->render('mirror/index.html.twig', [
            'controller_name' => 'MirrorController',
            'mirror_id' => $mirror_id,
        ]);
    }
}
