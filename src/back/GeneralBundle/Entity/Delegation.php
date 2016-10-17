<?php

namespace back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Delegation
 *
 * @ORM\Table(name="delegation")
 * @ORM\Entity(repositoryClass="back\GeneralBundle\Repository\DelegationRepository")
 */
class Delegation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="back\GeneralBundle\Entity\Governorat",inversedBy="delegations")
     */
    private $governorat;

    /**
     * @ORM\OneToMany(targetEntity="back\GeneralBundle\Entity\Localite",mappedBy="delegation")
     */
    private $localites;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Delegation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getGovernorat()
    {
        return $this->governorat;
    }

    /**
     * @param mixed $governorat
     * @return Delegation
     */
    public function setGovernorat($governorat)
    {
        $this->governorat = $governorat;
        return $this;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->localites = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add localite
     *
     * @param \back\GeneralBundle\Entity\Localite $localite
     *
     * @return Delegation
     */
    public function addLocalite(\back\GeneralBundle\Entity\Localite $localite)
    {
        $this->localites[] = $localite;

        return $this;
    }

    /**
     * Remove localite
     *
     * @param \back\GeneralBundle\Entity\Localite $localite
     */
    public function removeLocalite(\back\GeneralBundle\Entity\Localite $localite)
    {
        $this->localites->removeElement($localite);
    }

    /**
     * Get localites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocalites()
    {
        return $this->localites;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
