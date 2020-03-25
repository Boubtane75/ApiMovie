<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Form\UserType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(MailerInterface $mailer,Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new Utilisateur();
        $form = $this->createForm(UserType::class,$user);
        $manager = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $email = (new TemplatedEmail())
                ->from('m.ali.boubtane@gmail.com')
                ->to($user->getEmail())//
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Bienvenue sur le site de momo')
                ->htmlTemplate('emails/registration.html.twig')
                ->context([
                    'username'=> $user->getUsername()
                ]);
            $mailer->send($email);
            return $this->redirectToRoute('security_login');
        }



        return $this->render('security/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authen){

        $error = $authen->getLastAuthenticationError();
        return $this->render('security/login.html.twig',[
            'error'=>$error
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {

    }
}
