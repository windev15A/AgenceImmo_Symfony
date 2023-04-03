<?php

namespace App\Controller;

use App\Data\FilterData;
use App\Form\SearchType;
use App\Repository\BienRepository;
use App\Services\Favorite;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class SearchController extends AbstractController
{
    #[Route('/recherche', name: 'search_index')]
    public function index(BienRepository $repository, Request $request, Favorite $favorite, PaginatorInterface $paginator): Response
    {
        $filter = new FilterData();
        $form = $this->createForm(SearchType::class, $filter);
        $form->handleRequest($request);
        $biens = $paginator->paginate(
            $repository->searchBien($filter),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('pages/search/index.html.twig', [
            'biens' => $biens,
            'favorites' => $favorite->getAllFavorites(),
            'form' => $form
        ]);
    }
}
