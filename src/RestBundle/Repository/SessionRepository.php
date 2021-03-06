<?php

namespace RestBundle\Repository;
use back\GeneralBundle\Entity\User;

/**
 * SessionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SessionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUniqueDevice(User $user)
    {
        $query = $this->createQueryBuilder("s");
        $query
            ->select("distinct(s.deviceId ) as deviceId  ")
            ->where("s.user = :userId")
            ->setParameter("userId", $user->getId());
        return $query->getQuery()->getScalarResult();
    }
    public function deleteOldSession(User $user)
    {
        $query = $this->createQueryBuilder("s");
        $query
            ->delete("RestBundle:Session", "s")
            ->where("s.user = :userId")
            ->setParameters(array(
                "userId" => $user->getId()
            ))
            ->getQuery()->execute();
    }
}
