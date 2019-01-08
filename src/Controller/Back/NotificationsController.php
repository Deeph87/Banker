<?php

namespace App\Controller\Back;

use App\Entity\Friendship;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;

/**
 * @Route("/notifications")
 *
 * @IsGranted("ROLE_USER")
 */
class NotificationsController extends AbstractController
{
    /**
     * @Route("/", name="notifications")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        //get friends request of the authenticated user
        $friendRequests = $em->getRepository(Friendship::class)->findBy(['friend' => $this->getUser(), 'status' => 0]);

        return $this->render('notifications/index.html.twig', [
            'friendships' => $friendRequests,
        ]);
    }

    /**
     * @Route("/getMyNotifications")
     * Ajax call to display the notifCounter on the menu
     */
    public function getMyNotifications()
    {
        $em = $this->getDoctrine()->getManager();
        //get friends request of the authenticated user
        $friendRequests = $em->getRepository(Friendship::class)->findBy(['friend' => $this->getUser(), 'status' => 0]);

        return new Response(count($friendRequests));
    }
}
