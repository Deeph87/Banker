<?php

namespace App\Controller\Back;

use App\Entity\Friendship;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\Choice;

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
    public function add(Request $request)
    {
        $friendship = new Friendship();

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAllExceptMe($this->getUser()->getId());
        $form = $this->createFormBuilder($users)
            ->add('pseudo', null, array('label' => 'Entrer son pseudo'))
            ->add('Ajouter', SubmitType::class, array('label' => 'Add Friend'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $friendship = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('friends/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
