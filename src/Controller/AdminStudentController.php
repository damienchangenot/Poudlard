<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Form\TeacherType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path:"/admin/student" , name:"admin_student_")]
class AdminStudentController extends AbstractController
{
    #[Route(path:"/", name:"index", methods:"GET")]
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('admin/student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    #[Route(path:"/{id}", name:"show", methods:"GET")]
    public function show(Student $student): Response
    {
        return $this->render('admin/student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route(path:"/{id}/edit", name:"edit", methods:["GET","POST"])]
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        if ($student->getIsTeacher() == false) {
            $form = $this->createForm(StudentType::class, $student);
        } else {
            $form = $this->createForm(TeacherType::class, $student);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Si c\'est encore un coup Peeves il va m\'entendre ce coup-ci...');
            return $this->redirectToRoute('admin_student_index');
        }

        return $this->render('admin/student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path:"/{id}", name:"delete", methods:"DELETE")]
    public function delete(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $entityManager->remove($student);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'A mettre au compte des pertes et profit');
        return $this->redirectToRoute('admin_student_index');
    }
}
