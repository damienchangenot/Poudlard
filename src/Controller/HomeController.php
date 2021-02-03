<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'students' => $studentRepository->findBy([], ['id' => 'DESC'], 3),
        ]);
    }
}
