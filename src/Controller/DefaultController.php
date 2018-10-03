<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

//    /**
//     * @Route(path="/{name}", methods={"GET"})
//     * @param $name
//     * @return string
//     */
//    public function getName($name)
//    {
//        return $this->render('default/getName.html.twig', [
//            'name' => $name
//        ]);
//    }
}