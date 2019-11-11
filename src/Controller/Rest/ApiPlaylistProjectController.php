<?php

namespace App\Controller\Rest;


use App\Entity\ArtistBand;
use App\Entity\MusicFile;
use App\Entity\PlaylistProject;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;

class ApiPlaylistProjectController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/playlist/project/{id}", requirements={"id": "\d+"}, name="api_playlistproject")
     * @return Response
     */
    public function getPlaylistProjectByUser(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $playlistProject = $em->getRepository(PlaylistProject::class)->findBy(['artistbandplproject' => $id]);

        if (empty($playlistProject)) {
            return new JsonResponse(['message' => 'this member does not exist!'], Response::HTTP_NOT_FOUND);
        }
        return $this->handleView($this->view($playlistProject));
    }

    /**
     * @Rest\Get("/projectsowner", name="api_projectsowner")
     * @return Response
     */
    public function getPlaylistProjectByOwner()
    {
        $em = $this->getDoctrine()->getManager();

        $artistbandbyowner = $em->getRepository(ArtistBand::class)->findBy(['artistbandmember' => $this->getUser()->getId()]);

        $bandsbyowner = $artistbandbyowner[0]->getArtistbandProject()->getValues();
        if (empty($bandsbyowner)) {
            return new JsonResponse(['message' => 'this member does not exist!'], Response::HTTP_NOT_FOUND);
        }
        return $this->handleView($this->view($bandsbyowner));
    }

    /**
     * TEST
     * @Rest\Get("/lol", name="api_lol")
     * @Rest\View
     */
    public function lol()
    {
        $em = $this->getDoctrine()->getManager();
        $lol = $em->getRepository(MusicFile::class)->find(1364);
        $playlistProject = $em->getRepository(PlaylistProject::class)->findBy(['artistbandplproject' => 432]);
//        /* @var $playlistProject playlistProject[] */
//        $tab =[];
//        foreach ($playlistProject as $place) {
//            $tab[] = [
//                'id' => $place->getId(),
//                'name' => $place->getPlprojectname(),
//                'music' => $place->getMusicfilePlproject(),
//            ];
//        }

        // Récupération du view handler

        // Création d'une vue FOSRestBundle
        $view = View::create($lol);
        $view->setFormat('json');

        // Gestion de la réponse
        return $view;
    }
}
