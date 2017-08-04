<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PannierController extends Controller
{
    public function addProduitAction($idProduit, $idSupermarche, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $produit = $em->getRepository(Produit::class)->find($idProduit);
        $session = $request->getSession();
        if (!$session->has("produits"))
            $produits = array();
        else
            $produits = $session->get('produits');
        $produits[] = $produit;
        $session->set("produits", $produits);
        return $this->redirectToRoute("front_super_marches_details", array(
            "id" => $idSupermarche
        ));
    }

}
