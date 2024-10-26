<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/show', name: 'show')]
    public function show() : Response
    {
        return new Response('<h1>Bonjour 3A39</h>');
    }

    #[Route('/show2/{name}', name: 'show')]
    public function show2($name) : Response
    {
        return $this->render('test/index.html.twig', [
            'n' => $name,
        ]);
    }
}
