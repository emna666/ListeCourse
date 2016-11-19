<?php

namespace back\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Marque;
use back\GeneralBundle\Form\MarqueType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MarqueController extends Controller
{
    public function listAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $marques = $em->getRepository(Marque::class)->findAll();
        return $this->render("backGeneralBundle:marque:list.html.twig", array(
            'marques' => $marques
        ));
    }
    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
        {
            $marque = new Marque();
        }
        else
        {
            $marque =$em->find(Marque::class,$id);
        }
        $form=$this->createForm(MarqueType::class,$marque);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $marque=$form->getData();
            $em->persist($marque);
            $em->flush();
            $this->addFlash('success', "Votre marque a été enregistré avec succés");
            return $this->redirectToRoute('back_general_marque_list');
        }
        return $this->render("backGeneralBundle:marque:add_edit.html.twig",array(
            'form'=>$form->createView()
        ));

    }
    public function DeleteAction(Marque $marque)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($marque);
            $em->flush();
            $this->addFlash('success', "Votre marque a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_marque_list"));
    }
}
