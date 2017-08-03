<?php

namespace back\AdherentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('backAdherentBundle:Default:index.html.twig');
    }
}
