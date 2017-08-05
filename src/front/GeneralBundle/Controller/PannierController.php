<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Coupon;
use back\GeneralBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PannierController extends Controller
{
    public function produitsPdfAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("produits"))
            $produits = array();
        else
            $produits = $session->get('produits');
        $html2pdf = $this->get('app.html2pdf');
        $html2pdf->create();
        return $html2pdf->generatePdf($this->renderView(":Front/pannier:produitsPDF.html.twig",array("produits"=>$produits)),"abc");
    }
    public function couponsPdfAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("coupons"))
            $coupons = array();
        else
            $coupons = $session->get('coupons');
        $html2pdf = $this->get('app.html2pdf');
        $html2pdf->create();
        return $html2pdf->generatePdf($this->renderView(":Front/pannier:couponsPDF.html.twig",array("coupons"=>$coupons)),"abc");
    }

    public function listProduitsAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("produits"))
            $produits = array();
        else
            $produits = $session->get('produits');
        if(count($produits)==0)
            $this->addFlash("info", "Votre liste et vide");
        return $this->render(":Front/pannier:produits.html.twig",array(
            "produits"=>$produits
        ));
    }
    public function listCouponsAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("coupons"))
            $coupons = array();
        else
            $coupons = $session->get('coupons');
        if(count($coupons)==0)
            $this->addFlash("info", "Votre liste et vide");
        return $this->render(":Front/pannier:coupons.html.twig",array(
            "coupons"=>$coupons
        ));
    }

    public function deleteProduitAction(Produit $produit, Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("produits"))
            $produits = array();
        else
            $produits = $session->get('produits');
        $newProduits=array();
        foreach ($produits as $pp)
        {
            if($pp->getId()!=$produit->getId())
                $newProduits[]=$pp;
        }
        $session->set("produits", $newProduits);
        return $this->redirectToRoute("front_pannier_produits");
    }


    public function deleteCouponAction(Coupon $coupon, Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("coupons"))
            $coupons = array();
        else
            $coupons = $session->get('coupons');
        $newCoupons=array();
        foreach ($coupons as $cc)
        {
            if($cc->getId()!=$coupon->getId())
                $newCoupons[]=$cc;
        }
        $session->set("coupons", $newCoupons);
        return $this->redirectToRoute("front_pannier_coupons");
    }

    public function countProduitsAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("produits"))
            return new Response(0);
        else
        {
            $produits = $session->get('produits');
            return new Response(count($produits));
        }
    }

    public function countCouponsAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has("coupons"))
            return new Response(0);
        else
        {
            $coupons = $session->get('coupons');
            return new Response(count($coupons));
        }
    }

    public function addProduitAction($idProduit, $idSupermarche, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $produit = $em->getRepository(Produit::class)->find($idProduit);
        $session = $request->getSession();
        if (!$session->has("produits"))
            $produits = array();
        else
        {
            $produits = $session->get('produits');
            foreach ($produits as $pp)
            {
                if ($pp->getId() == $produit->getId())
                {
                    $this->addFlash("info", "Vous avez deja ce produit dans votre liste");
                    return $this->redirectToRoute("front_super_marches_details", array(
                        "id" => $idSupermarche
                    ));
                }
            }
        }
        $produits[] = $produit;
        $session->set("produits", $produits);
        $this->addFlash("success", "Le produit a été ajoutée dans votre liste des produits");
        return $this->redirectToRoute("front_super_marches_details", array(
            "id" => $idSupermarche
        ));
    }

    public function addcouponAction($idCoupon, $idSupermarche, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $coupon = $em->getRepository(Coupon::class)->find($idCoupon);
        $session = $request->getSession();
        if (!$session->has("coupons"))
            $coupons = array();
        else
        {
            $coupons = $session->get('coupons');
            foreach ($coupons as $cc)
            {
                if ($cc->getId() == $coupon->getId())
                {
                    $this->addFlash("info", "Vous avez deja ce coupon dans votre liste");
                    return $this->redirectToRoute("front_super_marches_details", array(
                        "id" => $idSupermarche
                    ));
                }
            }
        }
        $coupons[] = $coupon;
        $session->set("coupons", $coupons);
        $this->addFlash("success", "Le coupon a été ajoutée dans votre liste des coupons");
        return $this->redirectToRoute("front_super_marches_details", array(
            "id" => $idSupermarche
        ));
    }

}
