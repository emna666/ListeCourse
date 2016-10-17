<?php

namespace back\GeneralBundle\Controller;

use back\GeneralBundle\Entity\Delegation;
use back\GeneralBundle\Entity\Governorat;
use back\GeneralBundle\Entity\Localite;
use back\GeneralBundle\Form\DelegationType;
use back\GeneralBundle\Form\GovernoratType;
use back\GeneralBundle\Form\LocaliteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferentielController extends Controller
{
    public function governoratAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if ($id)
            $governorat = $em->find(Governorat::class, $id);
        else
            $governorat = new Governorat();

        $form = $this->createForm(GovernoratType::class, $governorat);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $governorat = $form->getData();
                $em->persist($governorat);
                $em->flush();
                $this->addFlash('success', "Votre Governorat a été avec enregistré avec succés");
                return $this->redirectToRoute("back_general_referentiel_governorat");
            }
        }
        $governorats = $em->getRepository(Governorat::class)->findAll();
        return $this->render("backGeneralBundle:ref:governorats.html.twig", array(
            'governorats' => $governorats,
            'form'        => $form->createView()
        ));
    }

    public function governoratDeleteAction(Governorat $governorat)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($governorat);
            $em->flush();
            $this->addFlash('success', "Votre Governorat a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_referentiel_governorat"));
    }

    public function delegationAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if ($id)
            $delegation = $em->find(Delegation::class, $id);
        else
            $delegation = new Delegation();

        $form = $this->createForm(DelegationType::class, $delegation);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $delegation = $form->getData();
                $em->persist($delegation);
                $em->flush();
                $this->addFlash('success', "Votre delegation a été avec enregistré avec succés");
                return $this->redirectToRoute("back_general_referentiel_delegation");
            }
        }
        $delegations = $em->getRepository(Delegation::class)->findAll();
        return $this->render("backGeneralBundle:ref:delegations.html.twig", array(
            'delegations' => $delegations,
            'form'        => $form->createView()
        ));
    }

    public function delegationDeleteAction(Delegation $delegation)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($delegation);
            $em->flush();
            $this->addFlash('success', "Votre delegation a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_referentiel_delegation"));
    }

    public function localiteAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if ($id)
            $localite = $em->find(Localite::class, $id);
        else
            $localite = new Localite();

        $form = $this->createForm(LocaliteType::class, $localite);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $localite = $form->getData();
                $em->persist($localite);
                $em->flush();
                $this->addFlash('success', "Votre localite a été avec enregistré avec succés");
                return $this->redirectToRoute("back_general_referentiel_localite");
            }
        }
        $localites = $em->getRepository(Localite::class)->findAll();
        return $this->render("backGeneralBundle:ref:localites.html.twig", array(
            'localites' => $localites,
            'form'        => $form->createView()
        ));
    }

    public function localiteDeleteAction(Localite $localite)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($localite);
            $em->flush();
            $this->addFlash('success', "Votre localité a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_referentiel_localite"));
    }
}
