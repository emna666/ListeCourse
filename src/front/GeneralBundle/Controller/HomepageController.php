<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Categories;
use back\GeneralBundle\Entity\Coupon;
use back\GeneralBundle\Entity\Marque;
use back\GeneralBundle\Entity\Supermarche;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function accueilAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $coupons = $em->getRepository(Coupon::class)->findAll();
        $marques = $em->getRepository(Marque::class)->findAll();
        $supermarches = $em->getRepository(Supermarche::class)->findAll();
        return $this->render('Front/homepage/index.html.twig', array(
            'coupons'     => $coupons,
            'marques'     => $marques,
            'suermarches' => $supermarches
        ));
    }

    public function supermarcheAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $supermarches = $em->getRepository(Supermarche::class)->findBy(array(), array(), 6);
        return $this->render('Front/homepage/supermarche.html.twig', array(
            'suermarches' => $supermarches
        ));
    }

    public function categorieAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        //dump();
        $categories = $em->getRepository(Categories::class)->getCategorieWithCountCoupons();
        return $this->render('Front/homepage/categorie.html.twig', array(
            'categories' => $categories
        ));
    }

    public function couponAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $coupons = $em->getRepository(Coupon::class)->findBy(array(), array(), 8);
        return $this->render('Front/homepage/coupon.html.twig', array(
            'coupons' => $coupons
        ));
    }


    public function contactUsAction()
    {
        return $this->render(':Front/contactAs:index.html.twig');
    }
}
