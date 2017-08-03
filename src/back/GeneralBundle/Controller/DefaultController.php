<?php

namespace back\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {


        $mailer = $this->get('swiftmailer.mailer');
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('emna.khemili@gmail.com')
            ->setTo('zied.kharraz@gmail.com')
            ->setBody("test")
        ;

        dump($mailer->send($message));
        return $this->render('backGeneralBundle:Default:dashboard.html.twig');
    }
}
