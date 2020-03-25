<?php

namespace App\Controller\admin;

use App\Entity\Coment;
use App\Entity\Event;
use App\Entity\Message;
use App\Entity\Utilisateur;
use App\Form\ComentType;
use App\Form\MessageType;
use App\Form\UserType;
use App\Repository\UtilisateurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ProfilController extends AbstractController
{

    private $repository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UtilisateurRepository $repository,UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }


    /**
     * @Route("/admin",name="admin")
     */

        public function show ( PaginatorInterface $pagination, Request $request)
    {
        $mess = new Message();
        $form = $this->createForm(MessageType::class,$mess);
        $form->handleRequest($request);

        $repoUser = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users =$repoUser->findAll();
       $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isSubmitted())
        {
            $mess->setCreatAt(new \DateTime());
            $em->persist($mess);
            $em->flush();
             foreach ($users as $user) {
                 $event = new Event();
                 $event->setMessage($mess)
                     ->setCreatat(new \DateTime())
                     ->setStatus(true)
                     ->setEvent($user)
                     ->setEvenement('News');
                 $em->persist($event);
                 $em->flush();
             }
           /* $this->addFlash('success','Profile modifié');
             return $this->redirectToRoute('home');*/

        }
         $pagination = $pagination->paginate(
                $this->repository->findAll(),
                $request->query->getInt('page', 1),
                5
            );


       $user = $pagination;

        return $this->render('admin/home.html.twig',[
             'user'=>$user,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/admin/new",name="admin.new")
     */

    public function new(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $user = new Utilisateur();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Profile créé');
            return $this->redirectToRoute('admin');

        }
        return $this->render('admin/new.html.twig',[
            'user'=> $user,
            'form' =>$form->createView()
        ]);

    }

    /**
     * @Route("/admin/{id}",name="admin.edit" , methods= "POST|GET")
     */
    public function edit (Utilisateur $user,Request $request)
    {
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isSubmitted())
        {

            $hash = $this->encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $em->flush();
            $this->addFlash('success','Profile modifié');
            return $this->redirectToRoute('admin');

        }
        return $this->render('admin/edit.html.twig',[
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}",name="admin.delete", methods="DELETE")
     */
    public function delete (Utilisateur $user)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();
        $this->addFlash('success','Profile suprimer');

        return $this->redirectToRoute('admin');
    }





}
