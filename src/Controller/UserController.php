<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'userName' => 'Amir',
        ]);
    }

    #[Route('/ListUser', name: 'ListUser')]
    public function List(): Response
    {
        $user =  array(array('name' => 'Amir', 'age' => 20,'image' => 'https://www.w3schools.com/w3images/avatar2.png'),
         array('name' => 'Ali', 'age' => 25,'image' => 'https://www.w3schools.com/w3images/avatar2.png'),
          array('name' => 'Hassan', 'age' => 30,'image' => 'https://www.w3schools.com/w3images/avatar2.png'));
        return $this->render('user/list.html.twig', [
           'users' => $user,
        ]);
    }

    #[Route('/detail/{name}', name: 'd')]
    public function detail($name): Response
    {
        return $this->render('user/detail.html.twig',[
            'name' => $name
        ]
        );
    }

}
