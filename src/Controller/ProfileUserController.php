<?php

namespace App\Controller;

use App\Form\ChangePseudoFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfileUserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManageInterface)
    {
        $this->entityManager = $entityManageInterface;
    }

    #[Route('/mon-profil', name: 'app_profile_user')]
    public function index(): Response
    {
        if($this->getUser()){
            return $this->render('profile_user/index.html.twig', [
                'controller_name' => 'ProfileUserController',
            ]);
        }else{
            return $this->render('security/login.html.twig',['last_username' => null, 'error' => null]);
        }
    }

    #[Route('/changer-mon-pseudo', name: 'app_profile_user_change_pseudo')]
    public function changePseudo(Request $request,UserRepository $userRepo): Response
    {
        if($this->getUser()){
            $user = $this->getUser();
            $form = $this->createForm(ChangePseudoFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
            
                $username = $form->get('pseudo')->getData();
                $user_username = $userRepo->findOneBy([
                    'pseudo' => $username,
                ]);

                if($user_username != null){
                    $message = 'Pseudo déjà utilisé';
                    // Add flash message
                    $this->addFlash("error", $message);
                    return $this->render('profile_user/change_pseudo.html.twig', array('changePseudo' => $form->createView()));       
                }else{
                    $message = 'Pseudo modifié';
                    // Add flash message
                    $this->addFlash("success", $message);
                    $user->setPseudo($username);
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    return $this->redirectToRoute('app_profile_user', [], Response::HTTP_SEE_OTHER);
                }
            }
            return $this->render('profile_user/change_pseudo.html.twig', array('changePseudo' => $form->createView()));
        }else{
            return $this->render('security/login.html.twig',['last_username' => null, 'error' => null]);
        }
    }
}