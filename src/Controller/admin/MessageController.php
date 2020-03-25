<?php


namespace App\Controller\admin;


use App\Entity\Event;
use App\Entity\Message;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_EDIT => ['preEdit']
        ];
    }

    public  function  preEdit(GenericEvent $event){

      if (method_exists($event->getSubject(),'setTitle'))
      {
          dd($event->getSubject());
          $event->getSubject()->setCreatAt(new \DateTime());
      }

    }
/*    public function fullAction(Request $request)
    {
        $Title = $request->query->get('Titre');
        $content = $request->query->get('content');
        $em = $this->getDoctrine()->getManager();
        $repoUser = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users =$repoUser->findAll();


        $mess = new Message();
            $mess->setCreatAt(new \DateTime())
                ->setTitle($Title)
                ->setContent($content);
            $em->persist($mess);
            $em->flush();
            foreach ($users as $user) {
                $event = new Event();
                $event->setMessage($mess)
                    ->setCreatat(new \DateTime())
                    ->setStatus(true)
                    ->setEvent($user);
                $em->persist($event);
                $em->flush();
            }
        // redirect to the 'list' view of the given entity ...
        return $this->redirectToRoute('easyadmin', array(
            'entity' => $this->request->query->get('entity'),
        ));
    }*/
}