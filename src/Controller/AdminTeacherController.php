<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\Teacher1Type;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin/teacher")]
class AdminTeacherController extends AbstractController
{
    #[Route(path:"/", name:"admin_teacher_index", methods:"GET")]
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('admin/teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }


    #[Route(path:"/new", name:"admin_teacher_new", methods:["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(Teacher1Type::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($teacher);
            $entityManager->flush();

            return $this->redirectToRoute('admin_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route(path:"/{id}", name:"admin_teacher_show", methods:"GET")]
    public function show(Teacher $teacher): Response
    {
        return $this->render('admin/teacher/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    #[Route(path:"/{id}/edit", name:"admin_teacher_edit", methods:["GET", "POST"])]
    public function edit(Request $request, Teacher $teacher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Teacher1Type::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route(path:"/{id}", name:"admin_teacher_delete", methods:"POST")]
    public function delete(Request $request, Teacher $teacher, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $entityManager->remove($teacher);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
}
