<?php
/**
 * Created by PhpStorm.
 * User: Brixton le Brave
 * Date: 03/12/2018
 * Time: 11:03
 */

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;

/**
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{

    /**
     *  * @Route("/profile/{pseudo}")
     */
    public function show(User $user)
    {
        dd($user);
    }
}