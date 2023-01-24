<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EmpRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Emp;
use App\Form\EmpType;

class EmpController extends AbstractController
{
    #[Route('/emp', name: 'app_emp')]
    public function index(): Response
    {
        return $this->render('emp/index.html.twig', [
            'controller_name' => 'EmpController',
        ]);
    }
    #[Route('/showE', name: 'show_emp', methods: ['GET'])]
    public function show(EmpRepository $empRepository): Response
    {
        return $this->render('emp/show.html.twig', [
            'emp' => $empRepository->findAll(),
        ]);
    }
    #[Route('/addE', name: 'add_emp', methods: ['GET', 'POST'])]
    public function new(Request $request, EmpRepository $empRepository): Response
    {
        $emp = new Emp();
        $form = $this->createForm(empType::class, $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empRepository->save($emp, true);

            return $this->redirectToRoute('show_emp', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emp/add.html.twig', [
            'emp' => $emp,
            'form' => $form,
        ]);
    }
    #[Route('/editE/{id}', name: 'edit_emp', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emp $emp, EmpRepository $empRepository): Response
    {
        $form = $this->createForm(empType::class, $emp);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('show_emp');
        }
        return $this->renderForm('emp/edit.html.twig',[
            'emp' => $emp,
            'form' => $form,
        ] );
    }
    #[Route('/delete/{id}', name: 'delete_emp')]
    public function delete($id): Response
    {
        $c =$this->getDoctrine()
            ->getRepository(emp::class)
            ->find($id);
        if (!$c){
            throw $this->createNotFoundException(
                'No empolyee found for id'.$id
            );
        }    
        $entityManager =$this->getDoctrine()->getManager();
        $entityManager->remove($c);
        $entityManager->flush();
        return $this->redirectToRoute('show_emp');
    }

}
