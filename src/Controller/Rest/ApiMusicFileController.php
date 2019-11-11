<?php

namespace App\Controller\Rest;

use App\Form\MusicFileType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\MusicFile;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View as View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ProjectController.
 * @FOSRest\RouteResource("ApiMusicFile",pluralize=false)
 */
class ApiMusicFileController extends AbstractFOSRestController implements ClassResourceInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @FOSRest\Post(
     *    path = "/boom",
     *    name = "app_boom",
     * )
     * @FOSRest\View(StatusCode = 201)
     * @ParamConverter("musicfile", converter="fos_rest.request_body")
     */
    public function createAction(MusicFile $musicfile)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($musicfile);
        $em->flush();

        return $musicfile;
    }


    /**
     * @FOSRest\Put("/modifymusic/{id}",  methods={"PUT"})
     * @param Request $request
     * @return View
     */
    public function updateMusicFileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $musicfile = $em
            ->getRepository(MusicFile::class)
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        /* @var $musicfile MusicFile */
        if (empty($musicfile)) {
            return View::create(JsonResponse(['message' => 'music file not found'], Response::HTTP_NOT_FOUND));
        }

        $form = $this->createForm(MusicFileType::class, $musicfile);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($musicfile);
            $em->flush();
            return $musicfile;
        } else {
            return $form;
        }
    }


    /**
     * @FOSRest\Delete("/removemusic/{id}")
     * @param Request $request
     */
    public function removeNewMusicFileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $musicfile = $em->getRepository(MusicFile::class)
            ->find($request->get('id'));
        /* @var $musicfile MusicFile */
        $em->remove($musicfile);
        $em->flush();

        return \FOS\RestBundle\View\View::create($musicfile, Response::HTTP_NO_CONTENT);
    }

}
