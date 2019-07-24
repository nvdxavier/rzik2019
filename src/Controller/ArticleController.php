<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;

class ArticleController extends AbstractController
{
    /**
     * @Route("/create/article", name="app_createarticle")
     */
    public function creataArticleAction()
    {
        $newarticle = new Article();
        $formArticle = $this->createForm(ArticleType::class, $newarticle);

        return $this->render('article/createArticle.html.twig', [
            'formArticle' => $formArticle,
        ]);
    }
}
