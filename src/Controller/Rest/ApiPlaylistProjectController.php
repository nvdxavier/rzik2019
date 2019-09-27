<?php

namespace App\Controller\Rest;


use App\Entity\PlaylistProject;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
}
