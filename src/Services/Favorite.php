<?php

namespace App\Services;

use App\Repository\BienRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Favorite
{

    private SessionInterface $session;

    private BienRepository $bienRepository;

    public function __construct(RequestStack $requestStack, BienRepository $repository)
    {
        $this->session = $requestStack->getSession();
        $this->bienRepository = $repository;
    }


    public function addToFavorite(int $id): void
    {
        $favorites = $this->session->get('favorites', []);
        if (!in_array($id, $favorites)) {
            $favorites[] = $id;
        }else{
            $search = array_search($id,$favorites, true);
            if($search !== false){
                unset($favorites[$search]);
            }

        }
        $this->session->set('favorites', $favorites);
    }


    public function getAllFavorites(){
        return $this->session->get('favorites', []);
    }

}