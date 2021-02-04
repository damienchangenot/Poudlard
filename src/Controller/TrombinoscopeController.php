<?php

namespace App\Controller;

use App\Entity\StudentSearch;
use App\Form\SearchStudentType;
use App\Repository\DirectorRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrombinoscopeController extends AbstractController
{
    /**
     * @Route("/trombinoscope", name="trombinoscope")
     * @param StudentRepository $studentRepository
     * @param Request $request
     * @return Response
     */
    public function index( StudentRepository $studentRepository, Request $request): Response
    {
        $studentSearch = new StudentSearch();
        $form = $this->createForm(SearchStudentType::class, $studentSearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $students = $studentRepository->findStudent($studentSearch);
        } else {
            $students  = $studentRepository->findBy([], ['id' => 'DESC']);
        }

        return $this->render('Trombi/index.html.twig', [
            'students' => $students,
            'form' => $form->createView(),
        ]);
    }
}
