<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use App\Repository\DirectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path:"/admin/director", name:"admin_")]
class AdminDirectorController extends AbstractController
{
    #[Route("/", name:"director_index", methods:"GET")]
    public function index(DirectorRepository $directorRepository): Response
    {
        return $this->render('admin/director/index.html.twig', [
            'directors' => $directorRepository->findAll(),
        ]);
    }

    #[Route(path:"/{id}/edit", name:"director_edit", methods:["GET","POST"])]
    public function edit(Request $request, Director $director, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'le directeur est mort ! vive le directeur !');
            return $this->redirectToRoute('admin_director_index');
        }

        return $this->render('admin/director/edit.html.twig', [
            'director' => $director,
            'form' => $form->createView(),
        ]);
    }

}
