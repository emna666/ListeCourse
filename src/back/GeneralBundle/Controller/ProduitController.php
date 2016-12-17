<?php

namespace back\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Produit;
use back\GeneralBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{
    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $produit = $em->getRepository(Produit::class)->findAll();
        return $this->render("backGeneralBundle:produit:list.html.twig", array(
            'produits' => $produit
        ));
    }
    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
            $produit = new Produit();
        else
            $produit =$em->find(Produit::class,$id);
        $form=$this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $produit=$form->getData();
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success', "Votre produit a été enregistré avec succés");
            return $this->redirectToRoute('back_general_produit_list');
        }
        return $this->render("backGeneralBundle:produit:add_edit.html.twig",array(
            'form'=>$form->createView()
        ));

    }
    public function DeleteAction(Produit $produit)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($produit);
            $em->flush();
            $this->addFlash('success', "Votre produit a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_produit_list"));
    }
}
