<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use App\Services\Favorite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *Home controller
 */
class HomeController extends AbstractController
{

    /**
     * @param BienRepository $repository
     * @param Favorite $favorite
     * @return Response
     */
    #[Route('/')]
    public function index(BienRepository $repository, Favorite $favorite): Response
    {

        $biens = $repository->getData(8);
        return $this->render('home.html.twig', [
            'biens' => $biens,
            'favorites' => $favorite->getAllFavorites()
        ]);
    }


    /**
     * @param Bien $bien
     * @return Response
     */
    #[Route('bien/{id}', name: 'bien.show', methods: 'GET')]
    public function show(Bien $bien): Response
    {
        return $this->render('pages/bien/show.html.twig', [
            'bien' => $bien
        ]);
    }

    /**
     * @param Bien $bien
     * @param Favorite $favorite
     * @return RedirectResponse
     */
    #[Route('bien/{id}/like', name: 'bien.like', methods: 'GET')]
    public function like(Bien $bien, Favorite $favorite): RedirectResponse
    {
        $favorite->addToFavorite($bien->getId());
        return $this->redirect('/');
    }
}