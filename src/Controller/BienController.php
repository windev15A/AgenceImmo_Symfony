<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Entity\Images;
use App\Form\BienType;
use App\Repository\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class BienController extends AbstractController
{
    /**
     * @param BienRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/bien', name: 'app_bien')]
    public function index(
        BienRepository     $repository,
        PaginatorInterface $paginator,
        Request            $request
    ): Response
    {
        $biens = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/bien/index.html.twig', [
            'biens' => $biens
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/bien/nouveau', name: 'bien.new', methods: ['POST', 'GET'])]
    public function new(
        Request                $request,
        EntityManagerInterface $manager
    ): Response
    {
        $bien = new Bien();
        $form = $this->createForm(BienType::class, $bien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bien = $form->getData();
            $images = $form->get('images')->getData();

            foreach ($images as $image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                // Creation d'une image en bd
                $img = new Images();
                $img->setName($file)
                    ->setPathImg($this->getParameter('images_directory'));
                $manager->persist($img);
                $manager->flush();
                $bien->addImage($img);
            }

            $manager->persist($bien);
            $manager->flush();
            $this->addFlash('success', 'Le bien à été ajouté avec succées');
            return $this->redirectToRoute('app_bien');
        }

        return $this->render('pages/bien/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('bien/{id}/edit', name: 'bien.edit', methods: ['POST', 'GET'])]
    public function edit(
        Bien                   $bien,
        Request                $request,
        EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(BienType::class, $bien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $bien = $form->getData();
            $images = $form->get('images')->getData();

            foreach ($images as $image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                // Creation d'une image en bd
                $img = new Images();
                $img->setName($file)
                    ->setPathImg($this->getParameter('images_directory'));
                $manager->persist($img);
                $manager->flush();
                $bien->addImage($img);
            }
            $manager->persist($bien);
            $manager->flush();
            $this->addFlash('success', 'Le bien a été bien modifier avec succées');
            return $this->redirectToRoute('app_bien');
        }
        return $this->render('pages/bien/edit.html.twig', [
            'form' => $form,
            'bien' => $bien
        ]);
    }

    #[Route('bien/{id}/destroy', name: 'bien.supprimer', methods: ['GET'])]
    public function destroy(
        BienRepository         $repository,
        EntityManagerInterface $manager,
        Bien                   $bien,
        ImageController        $imgctrl
    )
    {
        try {
            foreach ($bien->getImages() as $image) {
                $bien->removeImage($image);
                $imgctrl->delete($image, $manager);
            }

            $manager->remove($bien);
            $manager->flush();
            $this->addFlash('success', 'Le bien à été supprimer avec succés');
            return $this->redirectToRoute('app_bien');

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
