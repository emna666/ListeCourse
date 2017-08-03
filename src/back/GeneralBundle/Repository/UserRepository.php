<?php

namespace back\GeneralBundle\Repository;


class UserRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByRole($role)
    {
        $query = $this->createQueryBuilder("u");

        $query->where($query->expr()->like("u.roles",':role'));
        $query->setParameter('role','%'.$role.'%');

        return $query->getQuery()->getResult();
    }

    public function findSupermarcheByAdhrent($id){
        $query = $this->createQueryBuilder("a");
        $query->where("a.id = :id")
            ->Select("a.supermarche")
            ->setParameter(":id", $id);
        return $query->getQuery()->getResult();
    }
}
