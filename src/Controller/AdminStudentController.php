<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/student" , name="admin_student_")
 */
class AdminStudentController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param StudentRepository $studentRepository
     * @return Response
     */
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('admin/student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Student $student
     * @return Response
     */
    public function show(Student $student): Response
    {
        return $this->render('admin/student/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function edit(Request $request, Student $student): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_student_index');
        }
        $this->addFlash('success', 'Si c\'est encore un coup Peeves il va m\'entendre ce coup-ci...');
        return $this->render('admin/student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function delete(Request $request, Student $student): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'A mettre au compte des pertes et profit');
        return $this->redirectToRoute('admin_student_index');
    }
}
