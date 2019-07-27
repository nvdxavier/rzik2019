<?php
namespace App\Controller\Rest;

use Exception;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\ArtistBand;
use App\Entity\Playlist;
use App\Entity\Member;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class ApiMemberController extends FOSRestController
{

    /**
     * @Route("/playlist_of_user/{id}", name="api_pl_of_user")
     */
    public function showPlaylistOfUserAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $playlistofuser = $em->getRepository(Playlist::class)->findBy(['id' => $user]);

        $data = $this->get('jms_serializer')->serialize($playlistofuser, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Patch("/update/password/{token}")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function patchPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $response = $this->forward('App\Controller\SecurityController::resetPassword', [
            'request' => $request,
            'token' => $token,
            'passwordencoder' => $passwordEncoder
        ]);
        return $response;
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/update/member/{userid}")
     */
    public function patchMember(Request $request)
    {
        return $this->updateMember($request, false);
    }

    /**
     * @param Request $request
     * @param $clearmissing
     * @return object|FormInterface|null
     */
    private function updateMember(Request $request, $clearMissing)
    {
        $em = $this->getDoctrine()->getManager();

        $member = $em->getRepository(Member::class)->find($request->get('id'));
        /* @var $userid Member */

        if (empty($member)) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->get('firstname')) {
            $member->setFirstname($request->get('firstname'));
        }
        if ($request->get('lastname')) {
            $member->setLastname($request->get('lastname'));
        }
        $em->persist($member);
        $em->flush();
        return $member;
    }

    /**
     * @Rest\Get("/member/{id}", requirements={"id": "\d+"}, name="api_member")
     * @return Response
     */
    public function getMember(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository(Member::class)->find($id);

        if (empty($member)) {
            return new JsonResponse(['message' => 'this member does not exist!'], Response::HTTP_NOT_FOUND);
        }
        return $this->handleView($this->view($member));
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/reset/password/")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenGeneratorInterface $tokenGenerator
     */
    public function patchCurrentpassword(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        TokenGeneratorInterface $tokenGenerator)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($user === null) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $token = $tokenGenerator->generateToken();

        try {
            $user->setResetToken($token);
            $user->setPassword($encoder->encodePassword($user, $request->get('password')));
            $em->persist($user);
            $em->flush();
            return $request->get('password');
        } catch (Exception $e) {
            $this->addFlash('warning', $e->getMessage());
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/follow/artistband/{id}/{iduser}", requirements={"id": "\d+"})
     */
    public function patchFollowArtistband(int $id, int $iduser)
    {
        return $this->updateFollowArtistBand($id, $iduser);
    }

    /**
     * @param int $id
     * @param int $iduser
     * @return Member|View|object|null
     */
    private function updateFollowArtistBand(int $id, int $iduser)
    {
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository(Member::class)->find($iduser);
        $artistbandtofollow = $em->getRepository(ArtistBand::class)->find($id);

        /* @var $member Member */
        if (empty($member)) {
            return View::create(['message' => 'Member not found'], Response::HTTP_NOT_FOUND);
        }

        if ($member->getFollowartistband()->contains($artistbandtofollow) === true) {
            $member->removeFollowartistband($artistbandtofollow);
            $response = View::create(['message' => 'You do not follow this group anymore', 'followartistbandstate' => false], Response::HTTP_OK);

        } else {
            $member->getFollowartistband()->add($artistbandtofollow);
            $response = View::create(['message' => 'This band has been added to your follow list', 'followartistbandstate' => true], Response::HTTP_CREATED);
        }
        $em->persist($member);
        $em->flush();
        return $response;
    }

}
