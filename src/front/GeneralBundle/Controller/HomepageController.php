<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Coupon;
use back\GeneralBundle\Entity\Marque;
use back\GeneralBundle\Entity\Supermarche;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function accueilAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $coupons = $em->getRepository(Coupon::class)->findAll();
        $marques = $em->getRepository(Marque::class)->findAll();
        $supermarches = $em->getRepository(Supermarche::class)->findAll();
        return $this->render('frontGeneralBundle:Default:accueil.html.twig', array(
            'coupons' => $coupons,
            'marques' => $marques,
            'suermarches' => $supermarches
        ));
    }
}
