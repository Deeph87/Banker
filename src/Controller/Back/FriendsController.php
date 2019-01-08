<?php

namespace App\Controller\Back;

use App\Entity\Friendship;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
        $friends = $this->getUser()->getFriends();
        return $this->render('friends/index.html.twig', [
            'friends' => $friends,
        ]);
    }

    /**
     * @Route("/add", name="friend_add", methods="GET|POST")
     */
    public function add(Request $request)
    {
        $friendship = new Friendship();

        $form = $this->createFormBuilder()
            ->add('pseudo', null, array('label' => 'Entrer son pseudo'))
            ->add('Ajouter', SubmitType::class, array('label' => 'Add Friend'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pseudo = $form->getData(); //get the pseudo sended by post

            $em = $this->getDoctrine()->getManager();
            /** @var User $user **/
            $user = $em->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]); //get the user from his pseudo

            try {
                $friendship->setFriend($user)
                    ->setMe($this->getUser())
                    ->setStatus(self::PENDING);
                $em->persist($friendship);
                $em->flush();
            } catch(Exception $e) {
                printf($e);
            }

            return $this->redirectToRoute('task_success');
        }

        return $this->render('friends/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
