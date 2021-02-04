<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Entity\ActualitySearch;
use App\Form\SearchActualityType;
use App\Repository\ActualityRepository;
use App\Services\Slugify;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActualityController
 * @package App\Controller
 * @Route ("/actuality", name="actuality_")
 */
class ActualityController extends AbstractController
{
    private const RESULT_PAGE = 15;

    /**
     * @Route("/", name="index")
     * @param ActualityRepository $actualityRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(ActualityRepository $actualityRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $actualitySearch = new ActualitySearch();
        $form = $this->createForm(SearchActualityType::class, $actualitySearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualities = $actualityRepository->findActuality($actualitySearch);
        } else {
            $actualities = $actualityRepository->findBy([],['id' => 'DESC']);
        }
        $actualities = $paginator->paginate($actualities,
            $request->query->getInt('page',1),
            self::RESULT_PAGE
        );

        return $this->render('actuality/index.html.twig', [
            'actualities' => $actualities,
            'form' => $form->createView()
        ]);
    }
    /**
     * @param Actuality $actuality
     * @return Response
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Actuality $actuality): Response
    {
        return $this->render('actuality/show.html.twig', [
            'actuality' => $actuality
        ]);
    }
}