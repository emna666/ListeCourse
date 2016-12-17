<?php

namespace back\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Categories;
use back\GeneralBundle\Entity\Rayon;
use back\GeneralBundle\Entity\Supermarche;
use back\GeneralBundle\Form\CategoriesType;
use back\GeneralBundle\Form\RayonType;
use back\GeneralBundle\Form\SupermarcheType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SupermarcheController extends Controller
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
            $supermarche = new Supermarche();
        else
            $supermarche =$em->find(Supermarche::class,$id);
        $form=$this->createForm(SupermarcheType::class,$supermarche);
        $form->handleRequest($request);
        if ($form->isValid() and $form->isSubmitted())
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
    public function listRayonAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $rayons = $em->getRepository(Rayon::class)->findAll();
        return $this->render("backGeneralBundle:supermarche:rayon_list.html.twig", array(
            'rayons' => $rayons
        ));
    }
    public function ajouterRayonAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
            $rayon = new Rayon();
        else
            $rayon =$em->find(Rayon::class,$id);
        $form=$this->createForm(RayonType::class,$rayon);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $rayon=$form->getData();
            $em->persist($rayon);
            $em->flush();
            $this->addFlash('success', "Votre Rayon a été enregistré avec succés");
            return $this->redirectToRoute('back_general_rayon_list');
        }
        return $this->render("backGeneralBundle:supermarche:rayon_add_edit.html.twig",array(
            'form'=>$form->createView()
        ));

    }
    public function DeleteRayonAction(Rayon $rayon)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($rayon);
            $em->flush();
            $this->addFlash('success', "Votre rayon a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_rayon_list"));
    }

    public function listCategorieAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $categories = $em->getRepository(Categories::class)->findAll();
        return $this->render("backGeneralBundle:supermarche:categorie_list.html.twig", array(
            'categories' => $categories
        ));
    }
    public function ajouterCategorieAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
            $categorie = new Categories();
        else
            $categorie =$em->find(Categories::class,$id);
        $form=$this->createForm(CategoriesType::class,$categorie);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $rayon=$form->getData();
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('success', "Votre categorie a été enregistré avec succés");
            return $this->redirectToRoute('back_general_categorie_list');
        }
        return $this->render("backGeneralBundle:supermarche:categorie_add_edit.html.twig",array(
            'form'=>$form->createView()
        ));

    }
    public function DeleteCategorieAction(Categories $categories)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($categories);
            $em->flush();
            $this->addFlash('success', "Votre categorie a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_categorie_list"));
    }
}
