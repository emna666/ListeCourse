<?php

namespace front\GeneralBundle\Controller;

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

    public function detailsAction($id,Request $request)
    {
        dump($request->getSession()->get('produits'));
        $em = $this->get('doctrine.orm.entity_manager');
        $supermarche = $em->getRepository(Supermarche::class)->find($id);
        if (!$supermarche)
            throw  new \Exception("Supermarché not found");
        return $this->render(':Front/supermarche/details:index.html.twig', array(
            "supermarche" => $supermarche
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
