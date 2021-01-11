<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     * @return void
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager) {
        
        if(!$article){
            $article = new Article();
        }
        
        /*$form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();*/
        $form = $this->createForm(ArticleType::class, $article);                    

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
        }                  
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !==null
        ]);
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
