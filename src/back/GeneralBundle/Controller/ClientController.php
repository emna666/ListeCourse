<?php

namespace back\GeneralBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

        $clients = $em->getRepository(Client::class)->findAll();
        return $this->render("backGeneralBundle:client:list.html.twig", array(
            'clients' => $clients
        ));
    }

    public function ajouterAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $client = new Client();
        else
            $client = $em->find(Client::class, $id);
        $form = $this->createForm(ClientType::class, $client);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $client = $form->getData();
                $em->persist($client);
                $em->flush();
                $this->addFlash('success', " Opération réussie ");
                return $this->redirect($this->generateUrl('back_general_client_list'));
            }
        }
        return $this->render('backGeneralBundle:client:new.html.twig', array(
            'form'   => $form->createView(),
            'client' => $client,
        ));
    }

    public function clientDeleteAction(Client $client)
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
}
