<?php

namespace RestBundle\Service;

use back\GeneralBundle\Entity\Delegation;
use back\GeneralBundle\Entity\Governorat;
use back\GeneralBundle\Entity\Localite;
use back\GeneralBundle\Entity\Produit;
use back\GeneralBundle\Entity\Supermarche;
use back\GeneralBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use RestBundle\Entity\Session;
use RestBundle\Service\RestService;

class RestDataService
{
    private $em;
    private $restService;

    /*
     * Construct
     */
    public function __construct(EntityManager $entityManager, RestService $restService)
    {
        $this->em = $entityManager;
        $this->restService = $restService;

    }

    public function toArray($object)
    {
        if ($object instanceof User) {
            return array(
                "id" => $object->getId(),
                "full_name" => $object->getNom() . ' ' . $object->getPrenom(),
                "username" => $object->getUsername(),
                "email" => $object->getEmail()
            );
        } elseif ($object instanceof Session) {
            return array(
                "token" => $object->getToken(),
                "user" => $this->toArray($object->getUser())
            );
        } elseif ($object instanceof Governorat) {
            return array(
                "name" => $object->getName(),
            );
        } elseif ($object instanceof Delegation) {
            return array(
                "name" => $object->getName(),
                "governorat" => $this->toArray($object->getGovernorat())
            );
        } elseif ($object instanceof Localite) {
            return array(
                "name" => $object->getName(),
                "delegation" => $this->toArray($object->getDelegation())
            );
        } elseif ($object instanceof Produit) {
            return array(
                "libelle" => $object->getLibelle(),
                "photo" => $object->getAssetPath(),
                "prix" => $object->getPrix(),
                "numSerie" => $object->getNumSerie(),
                "description" => $object->getDescription()
            );
        } elseif ($object instanceof Supermarche) {
            return array(
                "id" => $object->getId(),
                "libelle" => $object->getLibelle(),
                "longitude" => $object->getLatitude(),
                "latitude" => $object->getLatitude(),
                "adresse" => $object->getAdresse(),
                "email" => $object->getEmail(),
                "photo" => $object->getAssetPath(),
                "localite" => $this->toArray($object->getLocalite())
            );
        } elseif ($object instanceof \DateTime)
            return $object->format("c");
        else
            return null;
    }

    public function getSupermarches()
    {
        $supermarches = $this->em->getRepository(Supermarche::class)->findAll();
        $reponse = array();
        foreach ($supermarches as $supermarche)
            $reponse[] = $this->toArray($supermarche);
        return $this->restService->successResponse($reponse);
    }

    public function getProduits($idSupermarche)
    {
        $supermarche = $this->em->getRepository(Supermarche::class)->find($idSupermarche);
        if ($supermarche) {
            $response = $this->toArray($supermarche);
            $response['produits'] = array();
            foreach ($supermarche->getProduits() as $produit)
                $response['produits'][] = $this->toArray($produit);
            return $this->restService->successResponse($response);
        } else
            return $this->restService->errorResponse("Pas de supermarché");
    }


}