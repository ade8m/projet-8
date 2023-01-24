<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dep;
use App\Repository\DepRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DepType;


class DepController extends AbstractController
{
    #[Route('/dep', name: 'app_dep')]
    public function index(): Response
    {
        return $this->render('dep/index.html.twig', [
            'controller_name' => 'DepController',
        ]);
    }
    #[Route('/showd', name: 'show_dep', methods: ['GET'])]
    public function show(DepRepository $depRepository): Response
    {
        return $this->render('dep/show.html.twig', [
            'dep' => $this->getDoctrine()->getRepository(dep::class)->findAll(),
        ]);
    }
    #[Route('/add', name: 'add_dep', methods: ['GET', 'POST'])]
    public function new(Request $request, DepRepository $depRepository): Response
    {
        $dep = new dep();
        $form = $this->createForm(depType::class, $dep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $depRepository->save($dep, true);

            return $this->redirectToRoute('show_dep', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dep/add.html.twig', [
            'dep' => $dep,
            'form' => $form,
        ]);
    }
}
