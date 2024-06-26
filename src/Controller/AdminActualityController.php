<?php


namespace App\Controller;


use App\Entity\Actuality;
use App\Form\ActualityType;
use App\Repository\ActualityRepository;
use App\Services\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path:"/admin/actuality", name:"admin_actuality_")]
class AdminActualityController extends AbstractController
{
    #[Route(path:"/", name:"index", methods:"GET")]
    public function index(ActualityRepository $actualityRepository): Response
    {
        return $this->render('admin/actuality/index.html.twig', [
            'actualities' => $actualityRepository->findAll(),
        ]);
    }

    #[Route(path:"/new", name:"new", methods:["GET","POST"])]
    public function new(Request $request, Slugify $slugify, EntityManagerInterface $entityManager): Response
    {
        $actuality = new Actuality();
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($actuality->getTitle());
            $actuality->setSlug($slug);
            $entityManager->persist($actuality);
            $entityManager->flush();
            $this->addFlash('success', 'Evénement ajouter, plus besoin de la pensine ;-)');
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
     * @param Slugify $slugify
     * @return Response
     */
    public function edit(Request $request, Actuality $actuality, Slugify $slugify, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($actuality->getTitle());
            $actuality->setSlug($slug);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez encore jouer avec le retourneur de temps avouez...?');
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
    public function delete(Request $request, Actuality $actuality, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actuality->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuality);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'vous avez effacé une pan de l\'histoire de l\'école bravo...');
        return $this->redirectToRoute('admin_actuality_index');
    }
}
