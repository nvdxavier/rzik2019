<?php

namespace App\Controller\Rest;

use App\Form\ArticleType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Schema\View;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Tag;
use App\Service\ApiService;

class ApiArticleController extends FOSRestController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var ApiService */
    private $apiService;

    /**
     * @Rest\Get("/showarticle/{articleId}", name="app_article")
     */
    public function getArticle(int $articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($articleId);

        return \FOS\RestBundle\View\View::create($article, Response::HTTP_CREATED);
    }

    /**
     * Creates an Article resource
     * @Rest\Post("/post_article", name="api_post_article")
     * @param Request $request
     * @return JsonResponse
     */
    public function postArticle(Request $request): JsonResponse
    {

        $article = new Article();

        $article->setMember($this->getUser());
        $article->setTitle($request->request->get('title'));
        $article->setContent($request->request->get('content'));
        $article->setTag($request->request->get('tag'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new JsonResponse(true);
    }

    /**
     * Replaces Article resource
     * @Rest\Put("/articles/{articleId}")
     */
    public function putArticle(int $articleId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($articleId);

        if (empty($article)) {
            return new JsonResponse(['message' => 'articles not found'], Response::HTTP_NOT_FOUND);
        }

        if ($article) {
            $article->setTitle($request->get('title'));
            $article->setContent($request->get('content'));
            $article->setTag($request->get('tag'));
            $em->merge($article);
            $em->flush();
            return $article;
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return \FOS\RestBundle\View\View::create($article, Response::HTTP_OK);
    }

    /**
     * Removes the Article resource
     * @Rest\Delete("/delete_articles/{articleId}")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteArticle(int $articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($articleId);
        /* @var $article Article */
        if ($article) {
            $em->remove($article);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/patch_article/{articleId}")
     */
    public function patchArticle(Request $request)
    {
        return $this->updateArticle($request, false);
    }

    /**
     * @param Request $request
     * @param $clearMissing
     * @return Article|null|object|FormInterface|JsonResponse
     */
    private function updateArticle(Request $request, $clearMissing)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($request->get('id'));

        /* @var $article Article */
        if (empty($article)) {
//            return new JsonResponse(['message' => 'articles not found'], Response::HTTP_NOT_FOUND);
            return \FOS\RestBundle\View\View::create(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $formArticle = $this->createForm(ArticleType::class, $article);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $formArticle->submit($request->request->all(), $clearMissing);

        if ($formArticle->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $em->persist($article);
            $em->flush();
            return $article;
        } else {
            return $formArticle;
        }
    }

    /**
     * Creates an tag resource
     * @Rest\Post("/post_tag/created", name="api_post_tage")
     * @param Request $request
     * @return JsonResponse
     */
    public function postTag(Request $request): JsonResponse
    {

        $newtag = $request->request->get('tag');
        $postEntity = $this->apiService->createTag($newtag);
        $data = $this->serializer->serialize($postEntity, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Get("/post_tag", name="api_get_tags")
     * @return JsonResponse
     */
    public function getTagsActions(): JsonResponse
    {
        $postEntities = $this->apiService->getAll();
        $data = $this->serializer->serialize($postEntities, 'json');

        return new JsonResponse($data, 200, [], true);
    }


}
