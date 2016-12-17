<?php

namespace back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="back\GeneralBundle\Repository\ProduitRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Produit
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
     * @ORM\Column(name="num_serie", type="string", length=255, nullable=true)
     */
    private $numSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255, nullable=true)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="back\GeneralBundle\Entity\Marque")
     */
    private $marque;

    /**
     * @ORM\ManyToMany(targetEntity="back\GeneralBundle\Entity\Categories", cascade={"persist"})
     */
    private $categories;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at",type="datetime", nullable=true)
     */
    private $updated;

    /**
     * Image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $url;

    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    private $file;

    public function getUploadRootDir()
    {
        return __dir__ . '/../../../../web/' . $this->getDirectory();
    }

    public function getDirectory()
    {
        return 'uploads/produits';
    }

    public function getAssetPath()
    {
        return $this->getDirectory() . '/' . $this->url;
    }

    public function getAbsolutePath()
    {
        return null === $this->url ? null : $this->getUploadRootDir() . '/' . $this->url;
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
        $this->oldFile = $this->getUrl();
        $this->updated = new \DateTime();
        if (null !== $this->file)
            $this->url = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null !== $this->file)
        {
            $this->file->move($this->getUploadRootDir(), $this->url);
            unset($this->file);
            if ($this->oldFile != null && file_exists($this->tempFile))
                unlink($this->tempFile);
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFile))
            unlink($this->tempFile);
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Produit
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
     * Set numSerie
     *
     * @param string $numSerie
     *
     * @return Produit
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Produit
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param string $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }


    /**
     * Set url
     *
     * @param string $url
     *
     * @return Produit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set marque
     *
     * @param \back\GeneralBundle\Entity\Marque $marque
     *
     * @return Produit
     */
    public function setMarque(\back\GeneralBundle\Entity\Marque $marque = null)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \back\GeneralBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
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
     * @return Produit
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
