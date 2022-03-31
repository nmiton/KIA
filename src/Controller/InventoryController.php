<?php

namespace App\Controller;

use App\Repository\ObjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/mon-inventaire', name: 'app_inventory')]
    public function index(ObjectsRepository $repoObjet): Response
    {
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            $items_user = $repoObjet->findByCountAllObjetsByUserId($this->getUser()->getId());
            return $this->render('inventory/index.html.twig', [
                'controller_name' => 'InventoryController',
                'userItems'=>$items_user,
            ]);
        }
    }
}
