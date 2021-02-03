<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Repository\ActualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActualityController
 * @package App\Controller
 * @Route ("/actuality", name="actuality_")
 */
class ActualityController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ActualityRepository $actualityRepository
     * @return Response
     */
    public function index(ActualityRepository $actualityRepository): Response
    {
        return $this->render('actuality/index.html.twig', [
            'actualities' => $actualityRepository->findBy([],['id' => 'DESC']),
        ]);
    }

    /**
     * @param Actuality $actuality
     * @return Response
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Actuality $actuality): Response
    {
        return $this->render('actuality/show.html.twig', [
            'actuality' => $actuality
        ]);
    }
}
