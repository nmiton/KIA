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
            $all_items = $repoObjet->findAll();
            return $this->render('shop/index.html.twig', [
                'controller_name' => 'ShopController',
                'shopItems'=>$all_items,
            ]);
        }
    }
}
