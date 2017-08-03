<?php

namespace back\AdherentBundle\Controller;

use back\GeneralBundle\Entity\Coupon;
use back\GeneralBundle\Form\CouponSearchType;
use back\GeneralBundle\Form\CouponType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CouponController extends Controller
{
    public function listAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createForm(CouponSearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
        {
            $data = $form->getData();
            $coupons = $em->getRepository(Coupon::class)->search($data);
        } else
        $coupons = $em->getRepository(Coupon::class)->search(array(), $this->getUser());
        return $this->render("backAdherentBundle:coupon:list.html.twig", array(
            'form'     => $form->createView(),
            'coupons' => $coupons
        ));
    }

    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if (is_null($id))
            $coupon = new Coupon();
        else
            $coupon = $em->find(Coupon::class, $id);
        $form = $this->createForm(CouponType::class, $coupon);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $coupon = $form->getData();
            $em->persist($coupon);
            $em->flush();
            $this->addFlash('success', "Votre coupon a été enregistré avec succés");
            return $this->redirectToRoute('adherent_coupon_list');
        }
        return $this->render("backAdherentBundle:coupon:add_edit.html.twig", array(
            'form' => $form->createView()
        ));

    }

    public function DeleteAction(Coupon $coupon)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($coupon);
            $em->flush();
            $this->addFlash('success', "Votre coupon a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("adherent_coupon_list"));
    }
}
