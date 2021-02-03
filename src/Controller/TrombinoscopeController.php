<?php

namespace App\Controller;

use App\Repository\DirectorRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrombinoscopeController extends AbstractController
{
    /**
     * @Route("/trombinoscope", name="trombinoscope")
     * @param StudentRepository $studentRepository
     * @param TeacherRepository $teacherRepository
     * @param DirectorRepository $directorRepository
     * @return Response
     */
    public function index( StudentRepository $studentRepository,
                           TeacherRepository $teacherRepository,
                           DirectorRepository $directorRepository
    ): Response
    {
        return $this->render('Trombi/index.html.twig', [
            'students' => $studentRepository->findAll(),
            'teachers' => $teacherRepository->findAll(),
            'director'=> $directorRepository->findOneBy([])
        ]);
    }
}
