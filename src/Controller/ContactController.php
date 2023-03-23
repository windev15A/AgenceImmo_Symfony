<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('pages/contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     */
    #[Route('/sendEmail', name: 'contact_send')]
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('send_email', $submittedToken)) {
            try {
                $email = (new Email())
                    ->from(new Address($request->get('email')))
                    ->to('admin@admin.fr')

                    ->subject('Me contacter')
                    ->text($request->get('message'));

                $mailer->send($email);
                $this->addFlash('success', 'Email envoyé avec success');
            } catch (Throwable $th) {
                $this->addFlash('error', "Impossible d'envoyer l'email");
                return $this->render('pages/contact/index.html.twig');

            }
        }
        return $this->render('pages/contact/index.html.twig');
    }
}
