<?php

namespace back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Governorat
 *
 * @ORM\Table(name="governorat")
 * @ORM\Entity(repositoryClass="back\GeneralBundle\Repository\GovernoratRepository")
 */
class Governorat
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
     * @ORM\OneToMany(targetEntity="back\GeneralBundle\Entity\Delegation",mappedBy="governorat")
     */
    private $delegations;


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
     * @return Governorat
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

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->delegations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add delegation
     *
     * @param \back\GeneralBundle\Entity\Delegation $delegation
     *
     * @return Governorat
     */
    public function addDelegation(\back\GeneralBundle\Entity\Delegation $delegation)
    {
        $this->delegations[] = $delegation;

        return $this;
    }

    /**
     * Remove delegation
     *
     * @param \back\GeneralBundle\Entity\Delegation $delegation
     */
    public function removeDelegation(\back\GeneralBundle\Entity\Delegation $delegation)
    {
        $this->delegations->removeElement($delegation);
    }

    /**
     * Get delegations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDelegations()
    {
        return $this->delegations;
    }
}
