<?php

namespace back\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('backGeneralBundle:Default:dashboard.html.twig');
    }
}
