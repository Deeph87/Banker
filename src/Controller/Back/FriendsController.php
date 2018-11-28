<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;

/**
 * @Route("/friends")
 *
 * @IsGranted("ROLE_USER")
 */
class FriendsController extends AbstractController
{
    /**
     * @Route("/", name="friends")
     */
    public function index()
    {
        $friends = $this->getUser()->getFriends();
        return $this->render('friends/index.html.twig', [
            'friends' => $friends,
        ]);
    }

    /**
     * @Route("/add", name="friend_add", methods="GET|POST")
     */
    public function add(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAllExceptMe($this->getUser()->getId());

        return $this->render('friends/add.html.twig', [
            'users' => $users,
        ]);
    }
}
