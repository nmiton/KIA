<?php

namespace App\Controller;

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
    #[Route('/magasin', name: 'app_shop')]
    public function index(ObjectsRepository $repoObjet): Response
    {
        if (!$this->getUser()) return $this->render('home/home.html.twig');

        $error = isset($_GET['error']) ? $_GET['error'] : "";

        $all_items = $repoObjet->findAll();
        return $this->render('shop/index.html.twig', [
            'money' => $this->getUser()->getMoney(),
            'controller_name' => 'ShopController',
            'shopItems' => $all_items,
            'error' => $error
        ]);
    }

    #[Route('/magasin/{id}', name: 'app_shop_buy_id')]
    public function achatObject(Objects $objet, ObjectsRepository $repoObjet, InventoryRepository $repoInv, UserRepository $repoUser): Response
    {
        if (!$this->getUser()) return $this->render('home/home.html.twig');

        $user = $this->getUser(); // $objet->getPrice()
        if ($user->getMoney() - 354444359 < 0) return $this->redirectToRoute('app_shop', ['error' => "Tu n'as pas assez d'argent."]);

        $user->setMoney($user->getMoney() - $objet->getPrice());
        $repoUser->add($user);

        $inv = new Inventory();
        $inv->setUser($this->getUser());
        $inv->setObjet($objet);
        $repoInv->add($inv);

        return $this->redirectToRoute('app_shop');
    }
}
