<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
{
    #[Route('/play', name: 'app_play')]
    public function index(): Response
    {
        // dd($this->getUser());
        if($this->getUser()!==null){
            $user=$this->getUser();
            if(!$user->isVerified()){
                return $this->render('registration/verify_my_email.html.twig');
            }else{
                return $this->render('play/main.html.twig');
            }
        }else{
            return $this->render('security/login.html.twig', ['last_username' => null, 'error' => null]);
        }
    }
}