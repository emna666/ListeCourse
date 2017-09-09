<?php
namespace back\AdherentBundle\Controller;
use back\GeneralBundle\Entity\Produit;
use back\GeneralBundle\Entity\User;
use back\GeneralBundle\Form\ProduitSearchType;
use back\GeneralBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{
    public function listAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createForm(ProduitSearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and  $form->isValid())
        {
            $data = $form->getData();
            $produits = $em->getRepository(Produit::class)->search($data);
        } else
            $produits = $em->getRepository(Produit::class)->search(array(), $this->getUser());
        //dump($produits);
        return $this->render("@backAdherent/Produit/list.html.twig", array(
            'form'     => $form->createView(),
            'produits' => $produits
        ));
    }

    public function ajouterAction($id, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if (is_null($id))
            $produit = new Produit();
        else
            $produit = $em->find(Produit::class, $id);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $produit = $form->getData();
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success', "Votre produit a été enregistré avec succés");
            return $this->redirectToRoute('adherent_produit_list');
        }
        return $this->render("@backAdherent/Produit/add_edit.html.twig", array(
            'form' => $form->createView()
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
        return $this->redirect($this->generateUrl("adherent_produit_list"));
    }
}
