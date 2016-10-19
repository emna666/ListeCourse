<?php

namespace back\GeneralBundle\Controller;

use back\GeneralBundle\Entity\User;
use back\GeneralBundle\Form\adherentType;
use back\GeneralBundle\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use back\GeneralBundle\Entity\Client;
use back\GeneralBundle\Form\ClientType;

/**
 * Client controller.
 *
 * @Route("/client")
 */
class ClientController extends Controller
{
    public function clientAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $clients = $em->getRepository(User::class)->findByRole("ROLE_CLIENT");
        return $this->render("backGeneralBundle:user:list.html.twig", array(
            'clients' => $clients
        ));
    }

    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
        {
            $user = new User();
            $form=$this->createForm(RegistrationType::class,$user, array('validation_groups' => array('Registration')));
        }
        else
        {
            $user =$em->find(User::class,$id);
            $form=$this->createForm(RegistrationType::class,$user, array('validation_groups' => array('Profile')));
            $form->remove("plainPassword");
        }
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $user=$form->getData();
            $em->persist($user->addRole("ROLE_CLIENT"));
            $em->flush();
            $this->addFlash('success', "Votre client a été avec enregistré avec succés");
            return $this->redirectToRoute('back_general_client_list');
        }
        return $this->render("backGeneralBundle:user:add_edit.html.twig",array(
            'form'=>$form->createView()
        ));

    }

    public function clientDeleteAction(User $client)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($client);
            $em->flush();
            $this->addFlash('success', "Votre client a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_client_list"));
    }

    public function adherentAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $adherents = $em->getRepository(User::class)->findByRole("ROLE_ADHERENT");
        return $this->render("backGeneralBundle:user:list_adherent.html.twig", array(
            'adherents' => $adherents
        ));
    }

    public function ajouteradhrentAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if(is_null($id))
        {
            $user = new User();
            $form=$this->createForm(adherentType::class,$user, array('validation_groups' => array('Registration')));
        }
        else
        {
            $user =$em->find(User::class,$id);
            $form=$this->createForm(adherentType::class,$user, array('validation_groups' => array('Profile')));
            $form->remove("plainPassword");
        }
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $user=$form->getData();
            $em->persist($user->addRole("ROLE_ADHERENT"));
            $em->flush();
            $this->addFlash('success', "Votre Adherent a été avec enregistré avec succés");
            return $this->redirectToRoute('back_general_adherent_list');
        }
        return $this->render("backGeneralBundle:user:add_edit_adherent.html.twig",array(
            'form'=>$form->createView()
        ));

    }

    public function adherentDeleteAction(User $adhrent)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        try
        {
            $em->remove($adhrent);
            $em->flush();
            $this->addFlash('success', "Votre adhérent a été supprimé avec succès");
        } catch
        (\Exception $ex)
        {
            $this->addFlash('danger', "Impossible de supprimer cette Ligne");
        }
        return $this->redirect($this->generateUrl("back_general_adherent_list"));
    }
}
