<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @param TransactionRepository $transactionRepository
     * @Route("/", name="transaction_index", methods="GET")
     * @return Response
     */
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('back/transaction/index.html.twig', ['transactions' => $transactionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="transaction_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
//        $em = $this->getDoctrine()->getManager();
        $transaction = new Transaction();
//        $options = [
//            'categories' => $em->getRepository(Category::class)->findAll()
//        ];

        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return $this->redirectToRoute('transaction_index');
        }

        return $this->render('back/transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transaction_show", methods="GET")
     * @param Transaction $transaction
     * @return Response
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render('back/transaction/show.html.twig', ['transaction' => $transaction]);
    }

    /**
     * @Route("/{id}/edit", name="transaction_edit", methods="GET|POST")
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function edit(Request $request, Transaction $transaction): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_edit', ['id' => $transaction->getId()]);
        }

        return $this->render('back/transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transaction_delete", methods="DELETE")
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function delete(Request $request, Transaction $transaction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transaction);
            $em->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }
}
