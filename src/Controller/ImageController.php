<?php

namespace App\Controller;

use App\Entity\Images;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image/{id}/delete', name: 'image.delete', methods: ['DELETE'])]
    public function delete(Images $image, EntityManagerInterface $manager): JsonResponse
    {
        $name = $image->getName();
        // delete file in directory
        unlink($this->getParameter('images_directory').'/'.$name);

        // Delete image from dataBase
        $manager->remove($image);
        $manager->flush();

        return new JsonResponse(['success' => 1]);
    }


}
