<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\SelectTypeActionType;
use App\Repository\ObjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/mon-inventaire/{id}', name: 'app_inventory_full', methods:['GET',"POST"])]
    public function fullInventory(Animal $animal, ObjectsRepository $repoObjet,Request $request): Response
    {
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            $items_user = $repoObjet->findByCountAllObjetsByUserId($this->getUser()->getId());
            $form = $this->createForm(SelectTypeActionType::class);
            //choix de tri du shop  (type d'action/orderBy)
            $form->handleRequest($request);
            //form de tri
            if ($form->isSubmitted() && $form->isValid()) {
                $typeAction = $form->get("actionType")->getData();
                //condition sur le form de tri
                if($typeAction == null){
                    $items_user = $repoObjet->findByCountAllObjetsByUserId($this->getUser()->getId());
                    return $this->render('inventory/index.html.twig', [
                        'controller_name' => 'InventoryController',
                        'userItems' => $items_user,
                        'animal' => $animal,
                        'form'=>$form->createView(),
                    ]);
                }else{
                    if($typeAction==null){
                        return $this->redirectToRoute('app_inventory_by_action_type', ['actionType' => "all" , 'id'=> $animal->getId()]);
                    }else{
                        return $this->redirectToRoute('app_inventory_by_action_type', ['actionType' => $typeAction , 'id'=> $animal->getId()]);
                    }
                }
            }
            return $this->render('inventory/index.html.twig', [
                'controller_name' => 'InventoryController',
                'userItems'=>$items_user,
                'animal' => $animal,
                'form'=>$form->createView(),
            ]);
        }
    }

    #[Route('/mon-inventaire/{id}/type-action/{actionType}', name: 'app_inventory_by_action_type', methods:['GET',"POST"])]
    public function inventoryByActionType(Animal $animal ,$actionType, Request $request,ObjectsRepository $ObjRepo): Response
    {
        if(!$this->getUser()){
            return $this->render('home/home.html.twig');   
        }else{
            $form = $this->createForm(SelectTypeActionType::class);
            //choix de tri du shop  (type d'action/orderBy)
            $form->handleRequest($request);
            
            // dd($actionType);
            if($actionType == null){
                $items_user = $ObjRepo->findByCountAllObjetsByUserId($this->getUser()->getId());
            }else{
                $items_user = $ObjRepo->findByCountAllObjetsByUserIdAndActionType($this->getUser()->getId(),$actionType,$animal->getAnimalType()->getId());
            }

            //form de tri
            if ($form->isSubmitted() && $form->isValid()) {
                $typeAction = $form->get("actionType")->getData();
                //condition sur le form de tri
                if($typeAction == null){
                    $items_user = $ObjRepo->findByCountAllObjetsByUserId($this->getUser()->getId());
                    return $this->render('inventory/index.html.twig', [
                        'controller_name' => 'InventoryController',
                        'userItems' => $items_user,
                        'animal' => $animal,
                        'form'=>$form->createView(),
                    ]);
                }else{
                    if($typeAction==null){
                        return $this->redirectToRoute('app_inventory_by_action_type', ['actionType' => "all" , 'id'=> $animal->getId()]);
                    }else{
                        return $this->redirectToRoute('app_inventory_by_action_type', ['actionType' => $typeAction , 'id'=> $animal->getId()]);
                    }
                }
            }

            return $this->render('inventory/index.html.twig', [
                'controller_name' => 'InventoryController',
                'userItems'=>$items_user,
                'animal' => $animal,
                'form'=>$form->createView(),
                'actionType' => $actionType,
            ]);
        }
    }
}