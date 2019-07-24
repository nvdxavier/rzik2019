<?php


namespace App\EventSubscriber;

use App\Events\Events;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Service\FileUploader;
use App\Service\Toolbox;

const MUSIC_FILE = ['MUSIC_FILE'];

class MusicFileSubscriber implements EventSubscriberInterface
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
            Events::ARTISTNEWPROJECT_REGISTRED_MUSICFILE => 'onArtistBandRegistratedMusic',
        ];
    }

    public function onArtistBandRegistratedMusic(GenericEvent $event)
    {
        $musicCollection = $event->getIterator()->current();

        $artistbandName = $event->getArguments()[1];
        $projectname = $event->getSubject()->getPlprojectname();
        $entitiesmusic = $event->getSubject()->getMusicfilePlproject();
        $directoryhandler = $this->uploader->directoryHandler($artistbandName, MUSIC_FILE, $projectname);
        $i = 1;


        foreach ($musicCollection['musicfileplproject'] as &$entitymusic) {

            $musicpath = $artistbandName . '/' .
                $this->toolbox->formatString($projectname) . '/' .
                MUSIC_FILE[0] . '/' .
                $entitymusic['filename']->getClientOriginalName();

            $this->uploader->upload($entitymusic['filename'], $directoryhandler);
            $music = $entitiesmusic[$i++];

            if (!is_null($music)) {
                $music->setFilename($musicpath);

                $music->setFiletitle($entitymusic['filename']->getClientOriginalName());
                $music->setFileartist($artistbandName);
                $music->setFiletransfertdate(new DateTime('now'));
                $music->setPlaylistproject($event->getSubject());
            }
        }
    }
}