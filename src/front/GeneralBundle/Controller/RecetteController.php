<?php

namespace front\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecetteController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $recettes = $em->getRepository(Recette::class)->findAll();
        return $this->render(':Front/recette/list:index.html.twig', array(
            "recettes" => $recettes
        ));
    }
    public function detailsAction($id,Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $recette = $em->getRepository(Recette::class)->find($id);
        dump($recette);
        if (!$recette)
            throw  new \Exception("recette not found");
        return $this->render(':Front/recette/details:index.html.twig', array(
            "recette" => $recette
        ));
    }

}
