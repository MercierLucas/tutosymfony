<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController{

    /**
     * @Route("/login",name="login")
     * @return
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }
}