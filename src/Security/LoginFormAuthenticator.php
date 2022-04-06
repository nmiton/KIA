<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\PayDay;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;
    private $repositoryUser;
    private $entityManager;

    public function __construct(UrlGeneratorInterface $urlGenerator, UserRepository $userRepo, EntityManagerInterface $entityManageInterface)
    {
        $this->urlGenerator = $urlGenerator;
        $this->repositoryUser = $userRepo;
        $this->entityManager = $entityManageInterface;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $u = $token->getUser();
        //on géneère la date du jour en mode date time pour modifier le champ derniere connexion du collabo
        $today = new \DateTime('now');
        //On pointe sur l'id de l'utilisateur
        //on récupère le collaborateur en fonction de son id d'utilisateur
        $user = $this->repositoryUser->findOneBy([
            'email' => $u->getEmail(),
        ]);
        //on met a jour le chp derniereConnexion de user
        $user->setLastConnection($today);
        $user->setLastActive($today);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $payDay = new PayDay();
        $payDay->jourDePaye($u, $this->repositoryUser);

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        try {
            return new RedirectResponse($this->urlGenerator->generate('app_home'));
        } catch (\Throwable $th) {
            throw new \Exception('TODO: provide a valid redirect inside ' . __FILE__);
        }
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
