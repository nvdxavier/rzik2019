<?php

namespace App\Controller;

use Exception;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Events\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\Member;
use App\Entity\ArtistBand;
use App\Form\ArtistBandType;
use App\Service\FileUploader;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the Member
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        if ($request->isMethod('POST')) {
            $user = new Member();
            $user->setEmail($request->request->get('email'));
            $user->setFirstname($request->request->get('Firstname'));
            $user->setLastname($request->request->get('Lastname'));
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $user->setRoles(explode(" ", $request->request->get('role')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            if (in_array('ROLE_ARTIST', $user->getRoles()) === true) {
                return $this->redirectToRoute('app_artistband_register');
            } else {
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('security/register.html.twig');
    }


    /**
     * @Route("/artist/band/register", name="app_artistband_register")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function artistBandRegister(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $artistBand = new ArtistBand();
        $em = $this->getDoctrine()->getManager();

        $formArtistBand = $this->createForm(ArtistBandType::class, $artistBand);
        $formArtistBand->handleRequest($request);

        if ($formArtistBand->isSubmitted() && $formArtistBand->isValid()) {
            $artistBand->setArtistbandMember($this->getUser());
            $event = new GenericEvent($artistBand, [$request->files->get('artist_band'), $artistBand->getArtistbandName()]);
            $eventDispatcher->dispatch(Events::ARTISTBAND_REGISTERED_PICTURE, $event);
            $em->persist($artistBand);
            $em->flush();

            return $this->redirectToRoute('artist_new_project');
        }

        return $this->render('security/artistBandregister.html.twig', array(
            'formArtistBand' => $formArtistBand->createView(),
        ));
    }

    /**
     * @Route("/forgottenPassword", name="app_forgotten_password")
     * @return Response
     */
    public function forgottenPassword(
        Request $request,
        Swift_Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator): Response
    {
        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();

            /* @var $user Member */
            $user = $entityManager->getRepository(Member::class)->findOneByEmail($email);

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('home');
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('home');
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new Swift_Message('Forgot Password'))
                ->setFrom('g.ponty@dev-web.io')
                ->setTo($user->getEmail())
                ->setBody(
                    "blablabla voici le token pour reseter votre mot de passe : " . $url,
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('notice', 'Mail envoyé');

            return $this->redirectToRoute('home');
        }

        return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        if ($request->isMethod('POST')) {

            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(Member::class)->findOneBy(["resetToken" => $token]);
            /* @var $user Member */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('rzik_edit_profile');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour');


            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        } else {
            return $this->render('security/reset_password.html.twig', ['token' => $token]);

        }

    }

    /**
     * @Route("/reset_current/password", name="app_reset_current_password")
     */
    public function resetCurrentPassword(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        TokenGeneratorInterface $tokenGenerator): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        /* @var $user Member */
        $user = $this->getUser();

        if ($user === null) {
            $this->addFlash('danger', 'Utilisateur Inconnu');
            return $this->redirectToRoute('home');
        }
        $token = $tokenGenerator->generateToken();

        try {
            $user->setResetToken($token);
            $user->setPassword($encoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();
            return $request->request->get('password');

        } catch (Exception $e) {
            $this->addFlash('warning', $e->getMessage());
            return $this->redirectToRoute('home');
        }
    }

}
