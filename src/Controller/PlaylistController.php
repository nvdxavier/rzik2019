<?php

namespace App\Controller;

use App\Entity\ArtistBand;
use App\Entity\PlaylistProject;
use App\Events\Events;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Playlist;
use App\Form\PlaylistType;

class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlist", name="playlist")
     */
    public function index()
    {
//        $this->denyAccessUnlessGranted('ROLE_ARTIST', null, 'Unable to access this page!');

        return $this->render('playlist/index.html.twig', [
            'controller_name' => 'PlaylistController',
        ]);
    }

    public function playlistbyuserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $idUser = $user->getId();
        $checkuser = ($idUser) ? $idUser : null;
        $getPlaylist = $em->getRepository('PlaylistBundle:Playlist')->findAll(array('id' => $idUser));

        if (!$getPlaylist) {
            $this->get('session')->getFlashBag()->add('danger', 'Playlist inexistante');
        }
        return $this->render('PlaylistBundle:Playlist:index.html.twig', array('playlists' => $getPlaylist,
            'user' => $checkuser));
    }


    /**
     * @Route("/create_playlist", name="create_playlist")
     */
    public function createPlaylistAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->get('session')->getFlashBag()->add('danger', 'veuillez vous connecter avant de créer une playliste');
            throw $this->createAccessDeniedException();
        } else {

            $em = $this->getDoctrine()->getManager();
//            $user = $this->get('security.context')->getToken()->getUser();
            $newplaylist = new Playlist();
            $formPlaylist = $this->createForm(PlaylistType::class, $newplaylist);
            $formPlaylist->handleRequest($request);

            if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()) {
//                $newplaylist->setUser($user);
                $em->persist($newplaylist);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'La playlist a été crée'
                );
                return $this->redirect($this->generateUrl('app_file'));
            }

            return $this->render('playlist/createplaylist.html.twig', array('formplaylist' => $formPlaylist->createView()));

        }
    }

    /**
     * @Route("/edit_playlist", name="edit_playlist")
     */
    public function deletePlaylistAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $playlist = $em->getRepository('PlaylistBundle:Playlist')->find($id);
        $em->remove($playlist);
        $em->flush();


        $this->get('session')->getFlashBag()->add(
            'notice',
            'La playlist a été supprimé'
        );
        return $this->redirect($this->generateUrl('app_file'));

    }

    /**
     * AJAX
     *
     * @param $id
     * @return JsonResponse
     */
    public function addToPlaylistAction($id, $playlistid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $playlist = $em->getRepository('PlaylistBundle:Playlist')->findBy(array('user' => $user, 'id' => $playlistid));
        $actualmusic = $em->getRepository('AudioBundle:Audio')->findBy(array('id' => $id));


        $playlist[0]->addMusiques($actualmusic[0]);
        $em->persist($playlist[0]);
        $em->flush();

//        $this->get('session')->getFlashBag()->clear();
        $this->get('session')->getFlashBag()->add('notice', 'mp3 rajouté à votre plaliste ' . $playlist[0]->getPlname());
        //ajoute l'id du mp3 à la playliste dont le nom, ayant l'id de la playlist : param id.mp3, id.playlist
        return new JsonResponse(true);
    }

}

