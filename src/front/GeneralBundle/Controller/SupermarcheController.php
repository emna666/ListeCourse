<?php

namespace front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SupermarcheController extends Controller
{
    public function listAction()
    {
        return $this->render(':Front/supermarche/list:index.html.twig');
    }
}
