<?php

namespace App\Controller;

use App\Repository\ObjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/magasin', name: 'app_shop')]
    public function index(ObjectsRepository $repoObjet): Response
    {
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            $all_items_user_not_own = $repoObjet->findAllObjetsNotOwnUserId($this->getUser()->getId());
            return $this->render('shop/index.html.twig', [
                'controller_name' => 'ShopController',
                'items'=>$all_items_user_not_own,
            ]);
        }
    }
}
