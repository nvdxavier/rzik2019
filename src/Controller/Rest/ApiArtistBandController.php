<?php


namespace App\Controller\Rest;

use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use App\Entity\PlaylistProject;
use App\Entity\ArtistBand;

class ApiArtistBandController extends FOSRestController
{
    /**
     * @Rest\Get("/search/city/{city}", name="app_article")
     */
    public function searchCity(Request $request)
    {
        $q = $request->request->get('term');
        $em = $this->getDoctrine()->getManager();
        $citysearch = $em->getRepository(ArtistBand::class)->findCityLike($q);

        return View::create($citysearch, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/artistband/projects/{id}", requirements={"id": "\d+"}, name="api_artistband_projects")
     * @return Response
     */
    public function getArtistBandProjectsAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $projectsbyartist = $em->getRepository(PlaylistProject::class)->findBy(['artistbandplproject' => $id]);

        if (!$projectsbyartist) {
            throw new EntityNotFoundException('project does not exist!');
        }
        return $this->handleView($this->view($projectsbyartist));
    }

    /**
     * @Rest\Get("/artistband/{id}", requirements={"id": "\d+"}, name="api_artistband")
     * @param int $id
     * @return Response
     */
    public function getArtistBand(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $artistband = $em->getRepository(ArtistBand::class)->find($id);
        if (!$artistband) {
            throw new EntityNotFoundException('this Artistband does not exist!');
        }

        return $this->handleView($this->view($artistband));

    }

    /**
     * @Rest\Post("/follow/artistband/{id}", requirements={"id": "\d+"}, name="api_follow_artistband")
     * @param int $id
     * @return JsonResponse
     */
    public function postArtistBand(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $artistbandtofollow = $em->getRepository(ArtistBand::class)->find($id);

        $artistbandtofollow->setFollowedbymember($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($artistbandtofollow);
        $em->flush();

        return new JsonResponse(true);
    }
}