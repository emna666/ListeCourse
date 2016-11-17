<?php

namespace back\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Supermarche;
use back\GeneralBundle\Form\SupermarcheType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class supermarcheController extends Controller
{
    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $supermarche = $em->getRepository(Supermarche::class)->findAll();
        return $this->render("backGeneralBundle:supermarche:list.html.twig", array(
            'supermarches' => $supermarche
        ));
    }
    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
        {
            $supermarche = new Supermarche();
        }
        else
        {
            $supermarche =$em->find(Supermarche::class,$id);
        }
        $form=$this->createForm(SupermarcheType::class,$supermarche);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $supermarche=$form->getData();
            $em->persist($supermarche);
            $em->flush();
            $this->addFlash('success', "Votre supermarché a été enregistré avec succés");
            return $this->redirectToRoute('back_general_supermarche_list');
        }
        return $this->render("backGeneralBundle:supermarche:add_edit.html.twig",array(
            'form'=>$form->createView()
        ));

    }
    public function DeleteAction(Supermarche $supermarche)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($supermarche);
            $em->flush();
            $this->addFlash('success', "Votre supermarché a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_supermarche_list"));
    }
}
