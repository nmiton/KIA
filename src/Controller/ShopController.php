<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Inventory;
use App\Form\OrderByShop;
use App\Repository\InventoryRepository;
use App\Repository\ObjectsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/magasin/{id}', name: 'app_shop', methods:['GET','POST'])]
    public function allItemsShop(Request $request,Animal $animal, ObjectsRepository $repoObjet): Response
    {
        // on recupere tous les objects
        $items = $repoObjet->findAll();
        if (!$this->getUser()) return $this->render('home/home.html.twig');
        //gestion des notifications
        $error = isset($_GET['error']) ? $_GET['error'] : null;
        $success = isset($_GET['success']) ? $_GET['success'] : null;
        $transaction = isset($_GET['transaction']) ? $_GET['transaction'] : null ;
        //choix de tri du shop  (type d'action/orderBy)
        $form = $this->createForm(OrderByShop::class);
        $form->handleRequest($request);
        //form de tri
        if ($form->isSubmitted() && $form->isValid()) {
            $orderBy = $form->get("orderBy")->getData();
            $typeAction = $form->get("actionType")->getData();
            //condition sur le form de tri
            if($orderBy == null && $typeAction == null){
                return $this->render('shop/index.html.twig', [
                    'controller_name' => 'ShopController',
                    'shopItems' => $items,
                    'animal' => $animal,
                    'form'=>$form->createView(),
                ]);
            }else{
                if($typeAction==null){
                    return $this->redirectToRoute('app_shop_action_object', ['actionType' => "all" ,'orderBy' => $orderBy , 'id'=> $animal->getId()]);
                }elseif($orderBy==null){
                    return $this->redirectToRoute('app_shop_action_object', ['actionType' => $typeAction ,'orderBy' => "none" , 'id'=> $animal->getId()]);
                }else{
                    return $this->redirectToRoute('app_shop_action_object', ['actionType' => $typeAction ,'orderBy' => $orderBy , 'id'=> $animal->getId()]);
                }
            }
        }

        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'shopItems' => $items,
            'error' => $error,
            'success'=> $success,
            'transaction'=>$transaction,
            'animal' => $animal,
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/magasin/{id}/{idObjet}', name: 'app_shop_buy_objet')]
    public function achatObject(Animal $animal, $idObjet, InventoryRepository $repoInv, UserRepository $repoUser,ObjectsRepository $objRepo): Response
    {
        if (!$this->getUser()) return $this->render('home/home.html.twig');
        
        //on récupère l'objet
        $objet=$objRepo->findOneBy(["id"=>$idObjet]);

        $user = $this->getUser();
        if ($user->getMoney() - $objet->getPrice() < 0) {
            return $this->redirectToRoute('app_shop', ['error' => "Tu n'as pas assez d'argent.", 'id'=>$animal->getId()]);
        }else{
            $user->setMoney($user->getMoney() - $objet->getPrice());
            $repoUser->add($user);
            
            $inv = new Inventory();
            $inv->setUser($this->getUser());
            $inv->setObjet($objet);
            // dd($objet);
            $repoInv->add($inv);
            return $this->redirectToRoute('app_shop', ['success' => $objet->getName()." acheté avec succès !", "transaction" => $objet->getPrice(), 'id'=>$animal->getId()]);
        }
    }

    #[Route('/magasin/{id}/type-action/{actionType}/tri-prix/{orderBy}', name: 'app_shop_action_object')]
    public function itemsByActionShop(Animal $animal, $orderBy ,$actionType, Request $request,ObjectsRepository $ObjRepo): Response
    {   
        if (!$this->getUser()) return $this->render('home/home.html.twig');

        if($actionType != "all"){
            if($orderBy == "none"){
                $items = $ObjRepo->findByActionType($actionType);
            }elseif($orderBy == "DESC"){
                $items = $ObjRepo->findByActionTypeOrderByPriceDesc($actionType);
            }elseif($orderBy == "ASC"){
                $items = $ObjRepo->findByActionTypeOrderByPriceAsc($actionType);
            }
        }else{
            if($orderBy == "none"){
                $items = $ObjRepo->findAll();
            }elseif($orderBy == "DESC"){
                $items = $ObjRepo->findAll(['price'=>'DESC']);
            }elseif($orderBy == "ASC"){
                $items = $ObjRepo->findAll(['price'=>'ASC']);
            }
        }
        //choix de tri du shop  (type d'action/orderBy)
        $form = $this->createForm(OrderByShop::class);
        $form->handleRequest($request);
        //form de tri
        if ($form->isSubmitted() && $form->isValid()) {
            $orderBy = $form->get("orderBy")->getData();
            $typeAction = $form->get("actionType")->getData();
            //condition sur le form de tri
            if($orderBy == null && $typeAction == null){
                return $this->render('shop/index.html.twig', [
                    'controller_name' => 'ShopController',
                    'shopItems' => $items,
                    'animal' => $animal,
                    'form'=>$form->createView(),
                ]);
            }else{
                if($typeAction==null){
                    return $this->redirectToRoute('app_shop_action_object', ['actionType' => "all" ,'orderBy' => $orderBy , 'id'=> $animal->getId()]);
                }elseif($orderBy==null){
                    return $this->redirectToRoute('app_shop_action_object', ['actionType' => $typeAction ,'orderBy' => "none" , 'id'=> $animal->getId()]);
                }else{
                    return $this->redirectToRoute('app_shop_action_object', ['actionType' => $typeAction ,'orderBy' => $orderBy , 'id'=> $animal->getId()]);
                }
            }
        }
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'shopItems' => $items,
            'animal' => $animal,
            'form'=>$form->createView(),
            'actionType' => $actionType ,
            'orderBy' => $orderBy 
        ]);
    }
}
