<?php
/**
 * Created by PhpStorm.
 * User: Brixton le Brave
 * Date: 03/10/2018
 * Time: 10:35
 */

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('Article/index.html.twig', [
           'articles' => $articles
        ]);
    }

    /**
     * @Route("/show/{id}", methods={"GET"})
     */
    public function show(Article $article)
    {
        return $this->render('Article/show.html.twig', [
           'article' => $article
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"}, name="add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse | \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index');
        }

        return $this->render('Article/new.html.twig', [
            'Article' => $article,
            'form' => $form->createView(),
        ] );
    }

    /**
     * @Route("/edit/{id}", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse | \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_show', ["id" => $article->getId()]);
        }

        return $this->render('Article/edit.html.twig', [
            'Article' => $article,
            'form' => $form->createView(),
        ] );
    }
}