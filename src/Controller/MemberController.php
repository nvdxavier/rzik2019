<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class MemberController extends AbstractController
{
    /**
     * @Route("/welcome/{user}", name="rzik_profile")
     * @param string $user
     */
    public function memberProfileAction(string $user)
    {
        $hasAccess = $this->isGranted('ROLE_ARTIST');
        if ($hasAccess) {
            $newarticle = new Article();
            $formArticle = $this->createForm(ArticleType::class, $newarticle, ['action' => $this->generateUrl('api_post_article')]);
            $formArticle->createView();
        }

        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
            'formArticle' => $formArticle ?? null,
            'user' => $user
        ]);
    }

    /**
     * @Route("/settings/my_profile/artist", name="rzik_edit_profile_artist")
     */
    public function editMyArtistProfilAction()
    {
        $user = ($this->getUser()) ? $this->getUser()->getId() : null;

        return $this->render('member/settings/profile_artist.html.twig', [
            'user' => $user,
            'datainfos' => null
        ]);
    }

    /**
     * @Route("/settings/my_profile/", name="rzik_edit_profile")
     */
    public function editMyProfileAction()
    {
        $user = ($this->getUser()) ? $this->getUser()->getId() : null;

        if (in_array('ROLE_ARTIST', $this->getUser()->getRoles())) {
            return $this->redirect($this->generateUrl('rzik_edit_profile_artist'));
        } else {
            return $this->render('member/settings/profile.html.twig', [
                'user' => $user,
                'datainfos' => null
            ]);
        }
    }

    /**
     * @Route("/test/posts", name="rzik_test")
     */
    public function testAction(Request $request): JsonResponse
    {

        $article = new Article();

        $article->setMember($this->getUser());
        $article->setTitle($request->request->get('title'));
        $article->setContent($request->request->get('content'));
        $article->setTag($request->request->get('tag'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return new JsonResponse(true);
    }

}
