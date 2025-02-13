<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        if($this->getUser()){
            return $this->render('home/home.html.twig');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setEmail($form->get('email')->getData());
            $user->setPseudo($form->get('pseudo')->getData());
            $user->setRoles(["ROLE_USER"]);
            $user->setIsActive(true);
            $user->setMoney(0);
            $user->setIsVerified(0);
            //$user->setScore(0);
            $user->setLastActive(new \DateTime());
            $user->setCreatedAt(new \DateTime());
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('keepitalive87@gmail.com', 'Keep It Alive'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre adresse mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            return $this->render('registration/check_email.html.twig');
            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_home');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse email a bien été vérifiée.');

        return $this->redirectToRoute('app_register');
    }

    #[Route('/verifyMyEmail', name: 'app_verify_my_email')]
    public function newVerificationEmail(Request $request): Response
    {
        if($this->getUser()->getIsVerified()){
            return $this->render('home/home.html.twig');
            $this->addFlash('success', 'Votre adresse email a bien été vérifiée.');
        }else{
            return $this->render('registration/verify_my_email.html.twig');
        }
    }

    #[Route('/newVerificationEmailUser', name: 'app_new_verification_email_user')]
    public function sendNewVerificationEmail(Request $request): Response
    {
        if($this->getUser() && !$this->getUser()->isVerified()){
            $user = $this->getUser();
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('keepitalive87@gmail.com', 'Keep It Alive'))
                ->to($user->getEmail())
                ->subject('Veuillez confirmer votre adresse mail')
                ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            return $this->render('registration/check_email.html.twig');
        }else{
            return $this->redirectToRoute('app_register');
        }
    }
}
