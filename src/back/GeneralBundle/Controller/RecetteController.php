<?php

namespace back\GeneralBundle\Controller;


use back\GeneralBundle\Entity\Recette;
use back\GeneralBundle\Form\RecetteSearchType;
use back\GeneralBundle\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecetteController extends Controller
{
    public function listAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createForm(RecetteSearchType::class);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $data = $form->getData();
            $recettes = $em->getRepository(Recette::class)->search($data);
        } else
        $recettes = $em->getRepository(Recette::class)->findAll();
        return $this->render("backGeneralBundle:recette:list.html.twig", array(
            'form'     => $form->createView(),
            'recettes' => $recettes
        ));
    }

    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if (is_null($id))
            $recette = new Recette();
        else
            $recette = $em->find(Recette::class, $id);
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $recette = $form->getData();
            $em->persist($recette);
            $em->flush();
            $this->addFlash('success', "Votre recette a été enregistré avec succés");
            return $this->redirectToRoute('back_general_recette_list');
        }
        return $this->render("backGeneralBundle:recette:add_edit.html.twig", array(
            'form' => $form->createView()
        ));

    }

    public function DeleteAction(Recette $recette)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($recette);
            $em->flush();
            $this->addFlash('success', "Votre recette a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_recette_list"));
    }
}
