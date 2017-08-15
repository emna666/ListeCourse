<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Coupon;
use back\GeneralBundle\Entity\Produit;
use back\GeneralBundle\Entity\Recette;
use back\GeneralBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PannierController extends Controller
{
    public function produitsPdfAction(Request $request)
    {
        //return $this->render(":Front/pannier:produitsPDF.html.twig",array("produits"=>$this->getUser()->getProduits()));
        $html2pdf = $this->get('app.html2pdf');
        $html2pdf->create();
        return $html2pdf->generatePdf($this->renderView(":Front/pannier:produitsPDF.html.twig",array("produits"=>$this->getUser()->getProduits())),"abc");
    }
    public function couponsPdfAction(Request $request)
    {
        $html2pdf = $this->get('app.html2pdf');
        $html2pdf->create();
        return $html2pdf->generatePdf($this->renderView(":Front/pannier:couponsPDF.html.twig",array("coupons"=>$this->getUser()->getCoupons())),"abc");
    }
    public function recettesPdfAction(Request $request)
    {
        $html2pdf = $this->get('app.html2pdf');
        $html2pdf->create();
        return $html2pdf->generatePdf($this->renderView(":Front/pannier:recettePDF.html.twig",array("recettes"=>$this->getUser()->getRecettes())),"abc");
    }

    public function listProduitsAction(Request $request)
    {
        if(count($this->getUser()->getProduits())==0)
            $this->addFlash("info", "Votre liste et vide");
        return $this->render(":Front/pannier:produits.html.twig",array(
            "produits"=>$this->getUser()->getProduits()
        ));
    }

    public function listRecetteAction(Request $request)
    {
        if(count($this->getUser()->getRecettes()) ==0)
            $this->addFlash("info", "Votre liste et vide");
        return $this->render(":Front/pannier:recette.html.twig",array(
            "recettes"=>$this->getUser()->getRecettes()
        ));
    }
    public function listCouponsAction(Request $request)
    {
        if(count($this->getUser()->getCoupons())==0)
            $this->addFlash("info", "Votre liste et vide");
        return $this->render(":Front/pannier:coupons.html.twig",array(
            "coupons"=>$this->getUser()->getCoupons()
        ));
    }

    public function deleteProduitAction(Produit $produit, Request $request)
    {
        $user =$this->getUser();
        /**
         * @var $user User
         */
        $user->removeProduit($produit);
        $em= $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("front_pannier_produits");
    }


    public function deleteCouponAction(Coupon $coupon, Request $request)
    {
        $user =$this->getUser();
        /**
         * @var $user User
         */
        $user->removeCoupon($coupon);
        $em= $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("front_pannier_coupons");
    }

    public function deleteRecetteAction(Recette $recette, Request $request)
    {
        $user =$this->getUser();
        /**
         * @var $user User
         */
        $user->removeCoupon($recette);
        $em= $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("front_pannier_recettes");
    }

    public function countProduitsAction(Request $request)
    {
        return new Response(count($this->getUser()->getProduits()));
    }

    public function countCouponsAction(Request $request)
    {
        return new Response(count($this->getUser()->getCoupons()));
    }
    public function countRecettesAction(Request $request)
    {
        return new Response(count($this->getUser()->getRecettes()));
    }
    public function addProduitAction($idProduit, $idSupermarche, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $produit = $em->getRepository(Produit::class)->find($idProduit);
        $user =$this->getUser();
        /**
         * @var $user User
         */
        try{
            $user->addProduit($produit);
            $em->persist($user);
            $em->flush();
        }
        catch (\Exception $exception)
        {
            $this->addFlash("info", "Vous avez déja ce produit");
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }
        $this->addFlash("success", "Le produit a été ajoutée dans votre liste des produits");
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    public function addcouponAction($idCoupon, $idSupermarche, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $coupon = $em->getRepository(Coupon::class)->find($idCoupon);
        $user =$this->getUser();
        /**
         * @var $user User
         */
        try{
            $user->addCoupon($coupon);
            $em->persist($user);
            $em->flush();
        }
        catch (\Exception $exception)
        {
            $this->addFlash("info", "Vous avez déja ce coupon");
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }
        $this->addFlash("success", "Le coupon a été ajoutée dans votre liste des coupons");
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
    public function addReceteAction($idRecette, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $recette = $em->getRepository(Recette::class)->find($idRecette);
        $user =$this->getUser();
        /**
         * @var $user User
         */
        try{
            $user->addRecette($recette);
            $em->persist($user);
            $em->flush();
        }
        catch (\Exception $exception)
        {
            $this->addFlash("info", "Vous avez déja cette recette");
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }
        $this->addFlash("success", "La recette a été ajoutée dans votre liste des recettes");
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

}
