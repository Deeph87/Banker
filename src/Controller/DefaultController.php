<?php
/**
 * Created by PhpStorm.
 * User: Brixton le Brave
 * Date: 01/10/2018
 * Time: 10:34
 */
namespace App\Controller;

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
     * @Route(path="/", methods={"GET"})
     *
     * @return string
     */

    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}