<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;

use Twig\Environment;
class ContactController extends AbstractController
{
   /**
 * @var \Swift_Mailer
 */
private $mailer;

/**
 * @var Environment
 */
private $renderer;



     /**
     * @Route("/contact", name="contact")
     */
    public function Contact(Request $request) {
        $Contact = new Contact();

        $form = $this->createForm(ContactType::class, $Contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->notify($Contact);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($Contact);
            $manager->flush();

            $this->addFlash('success', 'Votre message à été envoyé');

            return $this->redirectToRoute('index');
        }

        return $this->render('Contact/Contact_form.html.twig', [
            'ContactForm' => $form->createView(),
        ]);
    }





public function __construct(\Swift_Mailer $mailer , Environment $renderer)
{
    $this->mailer = $mailer;
    $this->renderer = $renderer;
}

public function notify(Contact $contact){
    $message = (new \Swift_Message('Agence : Salle'))
    ->setFrom('noreply@agence.fr')
    ->setTo('contact@agence.ft')
    ->setReplyTo($contact->getEmail())
    ->setBody($this->renderer->render('emails/contact.html.twig',[
        'contact'=>$contact
    ]), 'text/html'
    );
    $this->mailer->send($message);
}


}
