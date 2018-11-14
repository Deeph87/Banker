<?php
/**
 * Created by PhpStorm.
 * User: Brixton le Brave
 * Date: 01/10/2018
 * Time: 10:34
 */
namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 *
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route(name="app_front_default_home", path="/", methods={"GET"})
     */
    public function home()
    {
        return $this->render('front/default/home.html.twig');
    }
}
