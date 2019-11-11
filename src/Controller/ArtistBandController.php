<?php

namespace App\Controller;

use App\Entity\ArtistBand;
use App\Entity\Member;
use App\Entity\PlaylistProject;
use Doctrine\ORM\EntityNotFoundException;
use DoctrineExtensions\Query\Mysql\Year;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class ArtistBandController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @return Response
     */
    public function homeAction(): Response
    {
        $em = $this->getDoctrine();
//        $monthlyProjects = $em->getRepository(PlaylistProject::class)->findMonthlyProjects(new \DateTime('last month'));
        $monthlyProjects = $em->getRepository(PlaylistProject::class)->findNewestProject();
        return $this->render('home.html.twig', ['monthlyProjects' => $monthlyProjects]);
    }

    /**
     * @Route("/artistband/user/profile", name="artistband_userprofile")
     */
    public function artistbandUserProfileAction()
    {
        $em = $this->getDoctrine();
        $artistprojectsbyuser = $em->getRepository(ArtistBand::class)->findBy(['artistbandmember' => $this->getUser()]);

        return $this->render('artist_band/index.html.twig', [
            'firstname' => $this->getUser()->getFirstname(),
            'lastname' => $this->getUser()->getLastname(),
            'mypicture' => $this->getUser()->getMemberPicture(),
            'artistprojects' => $artistprojectsbyuser,
        ]);
    }

    /**
     * @Route("artistband/profile/{id}", requirements={"id": "\d+"}, name="artistband_profile")
     */
    public function artistBandProfileAction(int $id)
    {
        $em = $this->getDoctrine();

        $artistprofile = $em->getRepository(ArtistBand::class)->find($id);
        $logoband = $artistprofile->getArtistbandLogo()->first()->getPictureFile();

        $userid = is_null($this->getUser()) ? null : $this->getUser()->getId();

        return $this->render('artist_band/artistbandprofile.html.twig', [
            'artistprofile' => $artistprofile,
            'currentuserid' => $userid,
            'logoband' => $logoband,
        ]);
    }

}
