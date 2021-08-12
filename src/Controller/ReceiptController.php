<?php

namespace App\Controller;

use App\Entity\Receipt;
use App\Form\ReceiptType;
use App\Repository\ReceiptRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/receipt")
 */
class ReceiptController extends AbstractController
{
    /**
     * @Route("/", name="receipt_index", methods={"GET"})
     */
    public function index(ReceiptRepository $receiptRepository): Response
    {
        return $this->render('receipt/index.html.twig', [
            'receipts' => $receiptRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="receipt_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $receipt = new Receipt();
        $form = $this->createForm(ReceiptType::class, $receipt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($receipt);
            $entityManager->flush();

            return $this->redirectToRoute('receipt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('receipt/new.html.twig', [
            'receipt' => $receipt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="receipt_show", methods={"GET"})
     */
    public function show(Receipt $receipt): Response
    {
        return $this->render('receipt/show.html.twig', [
            'receipt' => $receipt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="receipt_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Receipt $receipt): Response
    {
        $form = $this->createForm(ReceiptType::class, $receipt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('receipt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('receipt/edit.html.twig', [
            'receipt' => $receipt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="receipt_delete", methods={"POST"})
     */
    public function delete(Request $request, Receipt $receipt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$receipt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($receipt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('receipt_index', [], Response::HTTP_SEE_OTHER);
    }
}
