<?php

namespace front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function accueilAction()
    {
        return $this->render('frontGeneralBundle:Default:accueil.html.twig');
    }
}
