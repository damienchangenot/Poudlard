<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\StudentSearch;
use App\Entity\User;
use App\Form\SearchStudentType;
use App\Form\StudentType;
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

    /**
     * @Route ("/edition-du-profil/", name="edit_profil")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $students = new Student();
        $form = $this->createForm(StudentType::class, $students);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var User $user */
            if (($students->getUser() == null)) {
                $students->setUser($this->getUser());
            }
            $user = $this->getUser();
            $user->setIsEdited(true);
            if (!in_array("ROLE_STUDENT", $user->getRoles())) {
                $user->setRoles(["ROLE_STUDENT"]);
            }
            $entityManager->persist($students);
            $entityManager->flush();
            $this->addFlash('success', 'Merci ! Tu as échapper de peu au sortilège Doloris !');

            return $this->redirectToRoute('home_index');
        }
        return $this->render('security/edit_profil.html.twig', [
            'student' => $students,
            'form' => $form->createView(),
        ]);
    }
}
