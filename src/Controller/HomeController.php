<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(BienRepository $repository)
    {
        $biens = $repository->getData(6);
        return $this->render('home.html.twig', [
            'biens' => $biens
        ]);
    }


    #[Route('bien/{id}', name: 'bien.show', methods: 'GET')]
    public function show(Bien $bien){

        return $this->render('pages/bien/show.html.twig', [
            'bien' => $bien
        ]);
    }
}