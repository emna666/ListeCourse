<?php

namespace back\GeneralBundle\Repository;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function search($data)
    {
        $query = $this->createQueryBuilder("p");

        $query->select("p");
        if (isset($data['marque']) && $data['marque'] != null)
            $query
                ->andWhere("p.marque = :idMarque")
                ->setParameter("idMarque", $data['marque']->getId());
        return $query->getQuery()->getResult();

    }
}