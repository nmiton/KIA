<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Inventory;
use App\Entity\Objects;
use App\Repository\InventoryRepository;
use App\Repository\ObjectsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/magasin/{id}', name: 'app_shop', methods:['GET'])]
    public function index(Animal $animal, ObjectsRepository $repoObjet): Response
    {
        if (!$this->getUser()) return $this->render('home/home.html.twig');

        $error = isset($_GET['error']) ? $_GET['error'] : "";
        $success = isset($_GET['success']) ? $_GET['success'] : "";
        $transaction = isset($_GET['transaction']) ? $_GET['transaction'] : "";

        $all_items = $repoObjet->findAll();
        return $this->render('shop/index.html.twig', [
            'money' => $this->getUser()->getMoney(),
            'controller_name' => 'ShopController',
            'shopItems' => $all_items,
            'error' => $error,
            'success'=>$success,
            'transaction'=>$transaction,
            'animal' => $animal,
        ]);
    }

    #[Route('/magasin/{id}/{idAnimal}', name: 'app_shop_buy_objet', methods:['GET'])]
    public function achatObject(Animal $animal, Objects $objet, InventoryRepository $repoInv, UserRepository $repoUser): Response
    {
        if (!$this->getUser()) return $this->render('home/home.html.twig');

        $user = $this->getUser();
        if ($user->getMoney() - $objet->getPrice() < 0) {
            return $this->redirectToRoute('app_shop', ['error' => "Tu n'as pas assez d'argent."]);
        }else{
            $user->setMoney($user->getMoney() - $objet->getPrice());
            $repoUser->add($user);
            
            $inv = new Inventory();
            $inv->setUser($this->getUser());
            $inv->setObjet($objet);
            $repoInv->add($inv);
            return $this->redirectToRoute('app_shop', ['success' => "Objet acheté avec succès!", "transaction" => $objet->getPrice(),'animal' => $animal]);
        }
    }
}
