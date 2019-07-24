<?php

namespace App\Security;

use App\Entity\ArtistBand;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Service\UserService;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager,
                                RouterInterface $router,
                                CsrfTokenManagerInterface $csrfTokenManager,
                                UserPasswordEncoderInterface $passwordEncoder,
                                EventDispatcherInterface $eventDispatcher
    )
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function supports(Request $request)
    {
        if ('rzik_edit_profile' === $request->attributes->get('_route')) {

            return 'rzik_edit_profile' === $request->attributes->get('_route')
                && $request->isMethod('POST');
        }

        if ('app_login' === $request->attributes->get('_route')) {

            return 'app_login' === $request->attributes->get('_route')
                && $request->isMethod('POST');
        }

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(Member::class)->findOneBy(['email' => $credentials['email']]);
        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $user = $token->getUser()->getFirstname() . '_' . $token->getUser()->getLastname();

        if ('rzik_edit_profile' === $request->attributes->get('_route')) {

            $credentials = $this->getCredentials($request);
            return new RedirectResponse($this->router->generate('rzik_edit_profile', ['user' => $user, 'token' => $credentials['csrf_token']]));
        } else {

            $projectbyartist = $this->entityManager->getRepository(ArtistBand::class)->findBy(['artistbandmember' => $token->getUser()]);
            if (in_array('ROLE_ARTIST', $token->getUser()->getRoles()) AND empty($projectbyartist)) {

                return new RedirectResponse($this->router->generate('app_artistband_register'));
            } else {
                return new RedirectResponse($this->router->generate('rzik_profile', ['user' => $user]));
            }
        }

    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );
        return $credentials;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }
}
