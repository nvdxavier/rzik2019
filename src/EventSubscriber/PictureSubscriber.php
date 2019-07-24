<?php


namespace App\EventSubscriber;

use App\Entity\ArtistBand;
use App\Events\Events;
use App\Service\Toolbox;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Service\FileUploader;

const PICTURE_BAND = ['PICTURE_BAND'];
const LOGO_BAND = ['LOGO_BAND'];
const PICTURE_PROJECT = ['PICTURE_PROJECT'];
const PICTURE_PROJECT_MAIN = ['PICTURE_PROJECT_MAIN'];

class PictureSubscriber implements EventSubscriberInterface
{

    private $uploader;
    private $toolbox;

    public function __construct(FileUploader $uploader, Toolbox $toolbox)
    {
        $this->uploader = $uploader;
        $this->toolbox = $toolbox;

    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::ARTISTBAND_REGISTERED_PICTURE => 'onArtistBandRegistratedPicture',
            Events::ARTISTNEWPROJECT_REGISTERED_PICTURE => 'onArtistNewProjectRegistratedPicture'
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onArtistBandRegistratedPicture(GenericEvent $event)
    {
        $picturesCollection = $event->getIterator()->current();
        $artistbandName = $event->getArguments()[1];

        foreach ($event->getSubject()->getArtistbandPicture() as &$value) {

            $filepicture = $picturesCollection['artistbandpicture']['__name__']['picturefile'];
            $directoryhandler = $this->uploader->directoryHandler($artistbandName, PICTURE_BAND);

            $value->setPictureArtistband($event->getSubject());
            $value->setPictureCategory(PICTURE_BAND);
            $value->setPicturename($filepicture->getClientOriginalName());

            if ($directoryhandler != false) {

                $finalpath = $artistbandName . '/' . PICTURE_BAND[0] . '/' . $filepicture->getClientOriginalName();
                $value->setPicturefile($finalpath);
                $this->uploader->upload($filepicture, $directoryhandler);
            }
        }

        foreach ($event->getSubject()->getArtistbandLogo() as &$value) {

            $filelogo = $picturesCollection['artistbandlogo']['__name__']['picturefile'];
            $directoryhandler = $this->uploader->directoryHandler($artistbandName, LOGO_BAND);

            $value->setLogoArtistband($event->getSubject());
            $value->setPictureCategory(LOGO_BAND);
            $value->setPicturename($filelogo->getClientOriginalName());
            if ($directoryhandler != false) {

                $finalpath = $artistbandName . '/' . LOGO_BAND[0] . '/' . $filelogo->getClientOriginalName();
                $value->setPicturefile($finalpath);
                $this->uploader->upload($filelogo, $directoryhandler);
            }
        }

    }

    /**
     * @param GenericEvent $event
     */
    public function onArtistNewProjectRegistratedPicture(GenericEvent $event)
    {

        //c'est le nom du groupe
        $artistbandName = $event->getArguments()[1];

        //c'est l'image principle de l'album
        $mainprojectpicture = $event->getArguments()[0]['mainpictureplproject'];

        //c'est les images de l'album
        $pictures = $event->getArguments()[0]['picturesplproject'];

        //entité Picture dans PlaylistPRoject
        $entitypictures = $event->getSubject()->getPicturesPlproject();

        //c'est le nom de l'album
        $projectname = $event->getSubject()->getPlprojectname();
        $directoryhandler = $this->uploader->directoryHandler($artistbandName, PICTURE_PROJECT, $projectname);

        if ($mainprojectpicture) {

            $mainpicturepath = $artistbandName . '/' .
                $this->toolbox->formatString($projectname) . '/' .
                PICTURE_PROJECT[0] . '/' .
                $mainprojectpicture['picturefile']->getClientOriginalName();

            $this->uploader->upload($mainprojectpicture['picturefile'], $directoryhandler);

            $entitymainpicture = $event->getSubject()->getMainpicturePlproject();
            $entitymainpicture->setPictureCategory(PICTURE_PROJECT_MAIN);
            $entitymainpicture->setPicturename($mainprojectpicture['picturefile']->getClientOriginalName());
            $entitymainpicture->setPicturefile($mainpicturepath);
            $entitymainpicture->setPlprojectOwner($event->getSubject());
        }

        if ($pictures) {
            $i = 1;
            foreach ($pictures as &$picturefile) {
                $picturespath = $artistbandName . '/' .
                    $this->toolbox->formatString($projectname) . '/' .
                    PICTURE_PROJECT[0] . '/' .
                    $picturefile['picturefile']->getClientOriginalName();

                $this->uploader->upload($picturefile['picturefile'], $directoryhandler);

                $picture = $entitypictures[$i++];

                $picture->setPictureCategory(PICTURE_PROJECT);
                $picture->setPicturename($picturefile['picturefile']->getClientOriginalName());
                $picture->setPicturefile($picturespath);
                $picture->setPlprojectOwner($event->getSubject());
            }
        }
    }

}

