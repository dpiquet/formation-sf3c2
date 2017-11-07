<?php

namespace AppBundle\Controller;

use AppBundle\Contact\Message;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class)
            ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Message $message */
            $message = $form->getData();

            $mail = new \Swift_Message($message->getSubject(), $message->getContent());
            $mail->setFrom($message->getEmail(), $message->getName());
            $mail->setTo('webmaster@hangman.com');

            $this->get('mailer')->send($mail);

            $this->addFlash('success', 'Votre message envoyé.');

            return $this->redirectToRoute('contact');
        }

        return $this->render('main/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
