<?php


namespace App\Controller\Rest;

use App\Entity\MusicFile;
use App\Entity\Playlist;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

define("NOT_CONNECTED", false);
define("CONNECTED", true);
define('IN_PLAYLIST', true);
define('NOT_IN_PLAYLIST', false);

/**
 * Class ApiPlaylistController
 * @package App\Controller\Rest
 */
class ApiPlaylistController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/playlist/check/musicid", name="api_checkmusicinplaylist")
     * @param Request $request
     * @Rest\View
     */
    public function checkMusicinPlaylist(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $checkplaylistforthismusic = $em->getRepository(Playlist::class)->findMusicInPlayliste($request->get('idplaylist'),
            $this->getUser()->getId(),
            $request->get('idmusic')
        );
//        dump($checkplaylistforthismusic);
        if (!empty($checkplaylistforthismusic)) {
            return View::create(['isinplaylist' => 'this song is already added in playlist'], Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/playlist/add", name="api_addtoplaylist")
     * @param Request $request
     * @return View|Response
     */
    public function addtoPlaylist()
    {
        if (!$this->getUser()) {
            $register = $this->generateUrl('app_register');
            $login = $this->generateUrl('app_login');

            return View::create(['message' => 'Connect or create account to add music',
                'connected' => NOT_CONNECTED,
                'register' => $register,
                'login' => $login
            ], Response::HTTP_OK);
        }
        $em = $this->getDoctrine()->getManager();
        $playlistbyuser = $em->getRepository(Playlist::class)->findBy(['member' => $this->getUser()]);
        return $this->handleView($this->view($playlistbyuser));
    }

    /**
     * @Rest\Post("/add/music/toplaylist", name="api_addmusictoplaylist")
     * @param Request $request
     * @return View
     */
    public function addMusicToPlaylist(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $musicfile = $em->getRepository(MusicFile::class)->find($request->get('musicid'));
        $playlist = $em->getRepository(Playlist::class)->findBy(['member' => $this->getUser(),
            'id' => $request->get('selectedplaylist')]);
        $playlist[0]->addMusicfile($musicfile);
        $em->persist($playlist[0]);
        $em->flush();

        return View::create(['message' => 'music ajouté'], Response::HTTP_CREATED);
    }

    /**
     * @Rest\Post("/create/playlist/add/music", name="api_createplaylist")
     * @param Request $request
     * @return View
     */
    public function createPlaylist(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $musicfile = $em->getRepository(MusicFile::class)->find($request->get('musicid'));

        $newplaylist = new Playlist();
        $newplaylist->addMusicfile($musicfile);
        $newplaylist->setMember($this->getUser());
        $newplaylist->setPlname($request->get('name'));
        $newplaylist->setDatecreatepl(new DateTime('now'));
        $em->persist($newplaylist);
        $em->flush();

        return View::create(['message' => 'Playlist créé'], Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/playlist/remove/music", methods={"PUT"})
     * @param $id
     * @param $idplaylist
     */
    public function removeFromPlaylist($id, $idplaylist)
    {
        $em = $this->getDoctrine()->getManager();
        $musicfile = $em->getRepository(MusicFile::class)->find($id);
        $playlist = $em->getRepository(Playlist::class)->findBy(['member' => $this->getUser(),
            'id' => $idplaylist]);
        $playlist[0]->removeMusicfile($musicfile);
        $em->persist($playlist[0]);
        $em->flush();
    }
}
