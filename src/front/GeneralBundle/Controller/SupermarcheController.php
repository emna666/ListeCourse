<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Categories;
use back\GeneralBundle\Entity\Produit;
use back\GeneralBundle\Entity\Rayon;
use back\GeneralBundle\Entity\Supermarche;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SupermarcheController extends Controller
{
    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $supermarches = $em->getRepository(Supermarche::class)->findAll();
        return $this->render(':Front/supermarche/list:index.html.twig', array(
            "supermarches" => $supermarches
        ));
    }

    public function detailsAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $supermarche = $em->getRepository(Supermarche::class)->find($id);
        if (!$supermarche)
            throw  new \Exception("Supermarché not found");
        $rayons = $em->getRepository(Rayon::class)->findAll();
        return $this->render(':Front/supermarche/details:index.html.twig', array(
            "supermarche" => $supermarche,
            "rayons" => $rayons
        ));
    }

    public function produitsAction($idSupermarche, $idCategorie)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $supermarche = $em->getRepository(Supermarche::class)->find($idSupermarche);
        $category = $em->getRepository(Categories::class)->find($idCategorie);
        if (!$supermarche)
            throw  new \Exception("Supermarché not found");
        $produits = $em->getRepository(Produit::class)->getProduits($idSupermarche,$idCategorie);
        return $this->render(':Front/supermarche/produits:index.html.twig', array(
            "supermarche" => $supermarche,
            "produits" => $produits,
            "category"=>$category
        ));
    }

    public function populaireAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $supermarches = $em->getRepository(Supermarche::class)->findBy(array(), array(), 6);
        return $this->render(':Front/supermarche:populaire.html.twig', array(
            'suermarches' => $supermarches
        ));
    }
}
