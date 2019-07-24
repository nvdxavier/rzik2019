<?php

namespace App\Controller;

use App\Form\MusicFileType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MusicFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Playlist;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use App\Entity\Tag;

class MusicFileController extends AbstractController
{
    /**
     * @Route("/music/file", name="app_file")
     */
    public function indexAction()
    {
        return $this->render('music_file/index.html.twig', [
            'controller_name' => 'MusicFileController',
        ]);
    }

    /**
     * @Route("/home", name="app_home")
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $user = $this->get('security.context')->getToken()->getUser();

//        $newmusics = $em->getRepository(MusicFile::class)->findRecent();
        $newmusics = $em->getRepository(MusicFile::class)->findBy([], ['filetransfertdate' => 'asc'], 10);
        $playlist = $em->getRepository(Playlist::class)->findBy([], ['datecreatepl' => 'asc'], 10);

        return $this->render('music_file/index.html.twig', [
            'controller_name' => 'MusicFileController',
            'musiques' => $newmusics]);
    }

    /**
     * @Route("/music/acquisition", name="app_newnmusic")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function newMusicFileAction(Request $request, FileUploader $fileUploader, Security $security): Response
    {
        $musicfile = new MusicFile();

        $formNewFileAudio = $this->createForm(MusicFileType::class, $musicfile);
        $formNewFileAudio->handleRequest($request);

        if ($formNewFileAudio->isSubmitted() && $formNewFileAudio->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $musicfile->setFiledate(new DateTime("now"));
            $musicfile->setFileartist($security->getUser()->getUsername());
            $audiofile = $formNewFileAudio['filename']->getData();
            $musicfile->setFilename($audiofile->getClientOriginalName());

            $em->persist($musicfile);
            $em->flush();

//            $audiofile = $musicfile->getFilename();
            $fileNameUploaded = $fileUploader->upload($audiofile);

        }

        return $this->render('music_file/newMusicFile.html.twig', [
            'formNewFileAudio' => $formNewFileAudio->createView(),
        ]);
    }

    /**
     * @Route("/music/modification/{id}", requirements={"id": "\d+"},name="app_acquisitionmusic")
     * @param Request $request
     * @param MusicFile $audio
     * @ParamConverter(
    name="musicfile",
    class="Entity\MusicFile"
     * )
     * @return Response
     */
    public function editAction(Request $request, MusicFile $audio)
    {
        $fileImgExists = 0;
        $fileAudioExists = 0;

        $em = $this->getDoctrine()->getManager();

        $audioname = $audio->getFilename();

        $audio->setFilename(
            new File($this->getParameter('upload_directory') . '/' . $audioname)
        );


        $formAudio = $this->createForm(MusicFileType::class, $audio);
        $formAudio->handleRequest($request);

        //var_dump($audio);

        if ($formAudio->isSubmitted() && $formAudio->isValid()) {
            //var_dump($audio);
        }

        if (file_exists($this->getParameter('upload_directory') . '/' . $imagename)) {
            $fileImgExists = 1;
        }

        if (file_exists($this->getParameter('upload_directory') . '/' . $audioname)) {
            $fileAudioExists = 1;
        }

        return $this->render('music_file/editMusicFile.html.twig',
            array(
                'formAudio' => $formAudio->createView(),
                'fileImgExists' => $fileImgExists,
                'fileImgName' => $imagename,
                'fileAudioExists' => $fileAudioExists,
                'fileAudioName' => $audioname,
            )
        );
    }

    /**
     * @Route("main", name="app_main")
     */
    public function relationAction()
    {
        return $this->render('music_file/vue.html.twig');
    }
}
