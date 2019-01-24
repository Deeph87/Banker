<?php

namespace App\Controller\Back;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use Psr\Log\LoggerInterface;
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
        return $this->render('Back/transaction/index.html.twig', ['transactions' => $transactionRepository->findBy(['user' => $this->getUser()])]);
    }


    /**
     * @param TransactionRepository $transactionRepository
     * @param Account $account
     * @Route("/account/{id}", name="transaction_index_by_account", methods="GET")
     * @return Response
     */
    //TODO: what this shit here ?
    /*
    public function indexByAccount(TransactionRepository $transactionRepository, Account $account): Response
    {
        dump($transactionRepository->findByAccount($account));
        return $this->render('Back/transaction/index.html.twig', ['transactions' => $transactionRepository->findByAccount($account)]);
    }
    */

    /**
     * @Route("/new/{id}", name="transaction_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request, Account $account): Response
    {
        $transaction = new Transaction();
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository(Category::class)->findAll();

        if($request->isMethod('post')) {

            $transaction->setAccount($account);
            $transaction->setAmount($request->get('amount'));
            $transaction->setCategory($em->getRepository(Category::class)->find($request->request->get('category')));
            $transaction->setUser($this->getUser());
            $em->persist($transaction);
            $em->flush();

            $this->addFlash('success', 'You\'ve successfully created a transaction (' . $transaction->getAmount() . '€) on this account !');
            return $this->redirectToRoute('account_show', ['id' => $account->getId()]);
        }

        return $this->render('Back/transaction/new.html.twig', [
            'transaction' => $transaction,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{id}", name="transaction_show", methods="GET")
     * @param Transaction $transaction
     * @return Response
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render('Back/transaction/show.html.twig', ['transaction' => $transaction]);
    }

    /**
     * @Route("/{id}/edit", name="transaction_edit", methods="GET|POST")
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function edit(Request $request, Transaction $transaction, LoggerInterface $logger): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->debug($transaction->getAmount());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_edit', ['id' => $transaction->getId()]);
        }

        return $this->render('Back/transaction/edit.html.twig', [
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
