<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use App\Services\Favorite;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/')]
    public function index(BienRepository $repository, Favorite $favorite)
    {

        $biens = $repository->getData(8);
        return $this->render('home.html.twig', [
            'biens' => $biens,
            'favorites' => $favorite->getAllFavorites()
        ]);
    }


    #[Route('bien/{id}', name: 'bien.show', methods: 'GET')]
    public function show(Bien $bien)
    {

        return $this->render('pages/bien/show.html.twig', [
            'bien' => $bien
        ]);
    }

    #[Route('bien/{id}/like', name: 'bien.like', methods: 'GET')]
    public function like(Bien $bien, Favorite $favorite)
    {
        $favorite->addToFavorite($bien->getId());
        return $this->redirect('/');
    }
}