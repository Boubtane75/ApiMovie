<?php

namespace App\Controller;

use App\Entity\Coment;
use App\Entity\Utilisateur;
use App\Form\ComentType;
use App\Form\UserType;
use App\Repository\ComentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("/profile/{id}", name="profile", methods="POST|GET")
     */

    public function profile (Utilisateur $user,Request $request)
    {
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isSubmitted())
        {
            $em->flush();
            $this->addFlash('success','Profile modifié');
            return $this->redirectToRoute('profile');

        }
        return $this->render('index/profile.html.twig',[
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/movie", name="movie")
     */
    public function movie()
    {

        return $this->render('index/Movie.html.twig');
    }


    /**
     * @Route("/people", name="people")
     */
    public function people()
    {

        return $this->render('index/people.html.twig');
    }


    /**
     * @Route("/Tchat", name="Tchat")
     */
    public function Tchat(Request $request,PaginatorInterface $paginator,ComentRepository $repo)
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();
        $coment = $repo->findAll();
        $comments = array_reverse($coment) ;

        $page = $paginator->paginate(
            $comments, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        $Coment = new Coment();
        $form = $this->createForm(ComentType::class,$Coment);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            $Coment->setCreatedAt(new \DateTime())
                    ->setAuthor($user);
            $manager->persist($Coment);
            $manager->flush();

            return $this->redirectToRoute('Tchat');
        }
        return $this->render('index/Tchat.html.twig',[
            'pagination'=>$page,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/Tchatjs",name="Tchatjs")
     */

    public function Tchatjs()
    {
        return $this->render('index/Tchatjs.html.twig',[
        ]);

    }
    /**
     * @Route("/Tchat/{id}",name="comment.delete", methods="DELETECOMMENT")
     */
    public function deletcomment (Coment $coment)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($coment);
        $em->flush();
        $this->addFlash('success','comment suprimer');

        return $this->redirectToRoute('Tchat');
    }



}
