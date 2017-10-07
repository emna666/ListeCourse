<?php

namespace back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserProduit
 *
 * @ORM\Table(name="liste_course")
 * @ORM\Entity(repositoryClass="back\GeneralBundle\Repository\UserProduitRepository")
 */
class UserProduit
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="back\GeneralBundle\Entity\User" ,inversedBy="maListe")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="back\GeneralBundle\Entity\Produit")
     */
    private $produit;

    public function __construct()
    {
        $this->quantity=1;
    }

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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return UserProduit
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set user
     *
     * @param \back\GeneralBundle\Entity\User $user
     *
     * @return UserProduit
     */
    public function setUser(\back\GeneralBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \back\GeneralBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set produit
     *
     * @param \back\GeneralBundle\Entity\Produit $produit
     *
     * @return UserProduit
     */
    public function setProduit(\back\GeneralBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \back\GeneralBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
