<?php


namespace App\Controller;


use App\Entity\Actuality;
use App\Form\ActualityType;
use App\Repository\ActualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/actuality", name="admin_actuality_")
 */
class AdminActualityController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param ActualityRepository $actualityRepository
     * @return Response
     */
    public function index(ActualityRepository $actualityRepository): Response
    {
        return $this->render('admin/actuality/index.html.twig', [
            'actualities' => $actualityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $actuality = new Actuality();
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actuality);
            $entityManager->flush();

            return $this->redirectToRoute('admin_actuality_index');
        }

        return $this->render('admin/actuality/new.html.twig', [
            'actuality' => $actuality,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Actuality $actuality
     * @return Response
     */
    public function edit(Request $request, Actuality $actuality): Response
    {
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_actuality_index');
        }

        return $this->render('admin/actuality/edit.html.twig', [
            'actuality' => $actuality,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Actuality $actuality
     * @return Response
     */
    public function delete(Request $request, Actuality $actuality): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actuality->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actuality);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_actuality_index');
    }
}
