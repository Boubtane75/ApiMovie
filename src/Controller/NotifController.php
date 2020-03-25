<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotifController extends AbstractController
{
    /**
     * @Route("/notif", name="notif")
     */
    public function index(EventRepository $eventRepository)
    {
        $user = $this->getUser()->getId();
        $repomess = $eventRepository->findByEventUser($user);
        $notif = $eventRepository->findBy(['user' =>  $user,'status' => true]);
      $tabmess = [];
       $numbertab = 0;
        foreach ($repomess as $reponse)
        {
            $tabrep = $repomess[$numbertab]->getMessage()->getTitle();
            array_push($tabmess, $tabrep);
            $numbertab++;
        }
        return $this->json(
            [
                'nbstatus' =>count($notif),
                'message'=>$tabmess,
                'status' => 200,
            ]
        );
    }



    /**
     * @Route("/notif/read", name="notif.read")
     */
    public function notifRead(EventRepository $eventRepository)
    {
        $user = $this->getUser()->getId();

        $userstatus =   $eventRepository->findBy(['user' =>  $user,'status' => true]);
       $em = $this->getDoctrine()->getManager();

        foreach ($userstatus as $status)
        {
            $status->setStatus(false);
            $em->persist($status);
            $em->flush();
        }
        return $this->json(
            [
                'statusNotif' => 0,
                'status' => 200,
            ]
        );
    }
}
