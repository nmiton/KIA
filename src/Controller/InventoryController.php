<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\ObjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/mon-inventaire/{id}', name: 'app_inventory', methods:['GET'])]
    public function index(Animal $animal, ObjectsRepository $repoObjet): Response
    {
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            $money = $this->getUser()->getMoney();
            $items_user = $repoObjet->findByCountAllObjetsByUserId($this->getUser()->getId());
            return $this->render('inventory/index.html.twig', [
                'controller_name' => 'InventoryController',
                'userItems'=>$items_user,
                'money' => $money,
                'animal' => $animal,
            ]);
        }
    }
}
