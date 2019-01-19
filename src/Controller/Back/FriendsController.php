<?php

namespace App\Controller\Back;

use App\Entity\Friendship;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
    CONST PENDING = 0;
    CONST ACCEPTED = 1;
    CONST REFUSED = 2;

    /**
     * @Route("/", name="friends")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $meFriendships = $em->getRepository(Friendship::class)->findBy(['me' => $this->getUser()]);
        $otherFriendships = $em->getRepository(Friendship::class)->findBy(['friend' => $this->getUser()]);
        $friendships = array_merge($meFriendships, $otherFriendships);

        return $this->render('friends/index.html.twig', [
            'friendships' => $friendships,
        ]);
    }

    /**
     * @Route("/add", name="friend_add", methods="GET|POST")
     */
    public function add(Request $request)
    {
        $friendship = new Friendship();
        $usersToAddWithoutMeAndFriends = [];

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $meFriends = $em->getRepository(Friendship::class)->findBy(['friend' => $this->getUser()]);
        $otherFriends = $em->getRepository(Friendship::class)->findBy(['me' => $this->getUser()]);

        foreach ($users as $u)
            if ($u->getId() != $this->getUser()->getId())
                $usersToAddWithoutMeAndFriends[$u->getPseudo()] = $u->getPseudo();

        foreach ($meFriends as $meFriend)
            if( in_array($meFriend->getMe()->getPseudo(), $usersToAddWithoutMeAndFriends) )
                unset($usersToAddWithoutMeAndFriends[$meFriend->getMe()->getPseudo()]);

        foreach ($otherFriends as $otherFriend)
            if( in_array($otherFriend->getFriend()->getPseudo(), $usersToAddWithoutMeAndFriends) )
                unset($usersToAddWithoutMeAndFriends[$otherFriend->getFriend()->getPseudo()]);


        $form = $this->createFormBuilder()
            ->add('pseudo', ChoiceType::class, array(
                'label' => 'Entrer son pseudo',
                'choices' => $usersToAddWithoutMeAndFriends
            ))
            ->add('Ajouter', SubmitType::class, array('label' => 'Add Friend'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pseudo = $form->getData(); //get the pseudo sended by post

            $em = $this->getDoctrine()->getManager();
            /** @var User $user **/
            $user = $em->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]); //get the user from his pseudo

            if(is_null($user)) {
                $this->addFlash('danger', 'The user doesn\'t exist');
                return $this->redirectToRoute('friends');
            }

            try {
                $friendship->setFriend($user)
                    ->setMe($this->getUser())
                    ->setStatus(self::PENDING);
                $em->persist($friendship);
                $em->flush();
            } catch(Exception $e) {
                printf($e);
            }

            $this->addFlash('success', 'Friend request was sended to ' . $pseudo['pseudo']) . '.';
            return $this->redirectToRoute('friends');
        }

        return $this->render('friends/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accept/{id}", name="friend_accept")
     */
    public function acceptFriend(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Friendship $friendship */
        $friendship = $em->getRepository(Friendship::class)->findOneBy(['friend' => $this->getUser(), 'me' => $user]);

        if(is_null($friendship))
            return new Response(0);

        $friendship->setStatus(self::ACCEPTED);
        $em->persist($friendship);
        $em->flush();

        return new Response(1);
    }

    /**
     * @Route("/decline/{id}", name="friend_decline")
     */
    public function declineFriend(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Friendship $friendship */
        $friendship = $em->getRepository(Friendship::class)->findOneBy(['friend' => $this->getUser(), 'me' => $user]);

        if(is_null($friendship))
            return new Response(0);

        $friendship->setStatus(self::REFUSED);
        $em->persist($friendship);
        $em->flush();

        return new Response(1);
    }

    /**
     * @Route("/cancel/{id}", name="friend_cancel")
     * @param User $user
     * @return Response
     */
    public function cancelFriend(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Friendship $friendship */
        $friendship = $em->getRepository(Friendship::class)->findOneBy(['me' => $this->getUser(), 'friend' => $user]);

        if(is_null($friendship))
            return new Response(0);

        $em->remove($friendship);
        $em->flush();

        return new Response(1);
    }
}
