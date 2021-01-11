<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Undocumented function
     * @Route("/", name="home")
     * @return void
     */
    public function home() {
        return $this->render('blog/home.html.twig');
    }

    /**
     * Undocumented function
     * @Route("/blog/{id}", name="blog_show")
     * @return void
     */
    public function show(Article $article) {
        return $this->render('blog/show.html.twig',[
            'article' => $article,
        ]);
    }
}
