<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Manual;
use App\Entity\Receipt;


/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $error = null;

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on recup le manual transmit
            $manual = $form->get('manual')->getData();

            if($manual != null) {
                //on genere un nouveau nom de fichier
                // $filename = md5(uniqid()) . '.' . $manual->guessExtension();
                $filename = $manual->getClientOriginalName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(strtolower($ext) == 'pdf') {
                    //On copie le fichier dans le dossier uploads
                    $manual->move(
                        $this->getParameter('upload_directory'), 
                        $filename
                    );
                    //on creer le manual dans la base
                    $man = new Manual();
                    $man->setName($filename);
                    $product->setManual($man);
                }
                else {
                    $pdf_error = 'The manual could not be uploaded because it is not a pdf file';
                }
            }

            $receipt = $form->get('receipt')->getData();
            if($receipt != null) {
                $filename = $receipt->getClientOriginalName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(strtolower($ext) == 'png' || strtolower($ext) == 'jpg' || strtolower($ext) == 'gif') {
                    $receipt->move(
                        $this->getParameter('upload_directory'),
                        $filename
                    );
                    $rec = new Receipt();
                    $rec->setName($filename);
                    $product->setReceipt($rec);
                }
                else {
                    $img_error = 'The receipt could not be uploaded because it is not a pdf file';
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on recup le manual transmit
            $manual = $form->get('manual')->getData();
            if($manual != null) {
                //on genere un nouveau nom de fichier
                // $filename = md5(uniqid()) . '.' . $manual->guessExtension();

                //On copie le fichier dans le dossier uploads
                $manual->move(
                    $this->getParameter('upload_directory'), 
                    $filename = $manual->getClientOriginalName()
                );
                //on creer le manual dans la base
                $man = new Manual();
                $man->setName($filename);
                $product->setManual($man);
            }

            $receipt = $form->get('receipt')->getData();
            if($receipt != null) {
                $receipt->move(
                    $this->getParameter('upload_directory'),
                    $filename = $receipt->getClientOriginalName()
                );
                $rec = new Receipt();
                $rec->setName($filename);
                $product->setReceipt($rec);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/manual/{id}", name="product_delete_manual", methods={"DELETE"})
     */
    public function deleteManual(Manual $manual, Request $request) {
        $data = json_decode($request->getContent(), true);

        //on verifir si le token est valide
        if($this->isCsrfTokenValid('delete'.$manual->getId(), $data['_token'])) {
            //on recupere le nom du fichier
            $name = $manual->getName();
            //on supprime le fichier
            unlink($this->getParameter('upload_directory') . '/' . $name);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($manual);
            $em->flush();

        // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
            
    }
}
