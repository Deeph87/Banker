<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", methods={"GET"}, name="category_index")
     * @param Request $request
     * @return Response
     */
    public function index()
    {

    }

    /**
     * @Route("/category/new", methods={"GET", "POST"}, name="category_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump("Hello");
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_new', [
                'category' => $category
            ]);
        }

        return $this->render('back/category/new.html.twig', [
            'Article' => $category,
            'form' => $form->createView(),
        ]);
    }

    public function store() {

    }

    public function show() {

    }

    public function edit() {

    }

    public function update() {

    }

    public function destroy() {

    }
}