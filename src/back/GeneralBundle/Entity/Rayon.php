<?php

namespace back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rayon
 *
 * @ORM\Table(name="rayon")
 * @ORM\Entity(repositoryClass="back\GeneralBundle\Repository\RayonRepository")
 */
class Rayon
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
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=255, nullable=true)
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity="back\GeneralBundle\Entity\Categories",mappedBy="rayon")
     */
    private $categories;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Rayon
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     *
     * @return Rayon
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
    public function __toString() {
        return $this->libelle;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \back\GeneralBundle\Entity\Categories $category
     *
     * @return Rayon
     */
    public function addCategory(\back\GeneralBundle\Entity\Categories $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \back\GeneralBundle\Entity\Categories $category
     */
    public function removeCategory(\back\GeneralBundle\Entity\Categories $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
