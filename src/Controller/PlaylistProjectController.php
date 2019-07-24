<?php

namespace App\Controller;

use App\Entity\ArtistBand;
use App\Entity\Picture;
use App\Entity\PlaylistProject;
use App\Events\Events;
use App\Form\PlaylistProjectType;
use App\Form\PlaylistType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class PlaylistProjectController extends AbstractController
{

    /**
     * @Route("/playlist/project", name="playlist_project")
     */
    public function index()
    {
        return $this->render('playlist_project/index.html.twig', [
            'controller_name' => 'PlaylistProjectController',
        ]);
    }

    /**
     * @Route("/project/{id}", requirements={"id": "\d+"}, name="project_byartist")
     */
    public function projectByArtist(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $projectbyartist = $em->getRepository(PlaylistProject::class)->find($id);
        $picturefilelogo = $projectbyartist->getArtistbandPlproject()->getArtistbandLogo()->first()->getPicturefile();

        return $this->render('playlist_project/projectbyartist.html.twig', [
            'projectByArtist' => $projectbyartist,
            'logoband' => $picturefilelogo
        ]);
    }

    /**
     * @param FileUploader $fileUploader
     * @param Request $request
     * @Route("/artist/new/project", name="artist_new_project")
     */
    public function artistNewProjectAction(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getFirstname() . '_' . $this->getUser()->getLastname();

        $newProject = new PlaylistProject();

        $formProject = $this->createForm(PlaylistProjectType::class, $newProject);
        $formProject->handleRequest($request);

        $artistBand = $em->getRepository(ArtistBand::class)->findBy(['artistbandmember' => $this->getUser()->getId()]);

//        dump($artistBand[0]);exit();

        if ($formProject->isSubmitted() && $formProject->isValid()) {
//            dump($artistBand); exit();
            $event = new GenericEvent($newProject, [$request->files->get('playlist_project'), $artistBand[0]->getArtistbandName()]);
            $eventDispatcher->dispatch(Events::ARTISTNEWPROJECT_REGISTERED_PICTURE, $event);
            $eventDispatcher->dispatch(Events::ARTISTNEWPROJECT_REGISTRED_MUSICFILE, $event);
            $newProject->setArtistbandPlproject($artistBand[0]);
            $em->persist($newProject);
            $em->flush();

            return $this->redirect($this->generateUrl('artistband_profile', array('user' => $user)));

        }

        return $this->render('playlist_project/newproject.html.twig', [
            'formProject' => $formProject->createView(),
            'artistBand' => $artistBand[0],
        ]);
    }

}
