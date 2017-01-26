<?php

namespace back\GeneralBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="back\GeneralBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="nom", type="string", length=255 , nullable=true)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="cin", type="string", length=255 , nullable=true)
     */
    private $cin;
    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="prenom", type="string", length=255 , nullable=true)
     */
    private $prenom;
    /**
     * @var string
     * @ORM\Column(name="telephone" , type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     * @ORM\Column(name="telephone2" , type="string", length=255, nullable=true)
     */
    private $telephone2;

    /**
     * @ORM\ManyToOne(targetEntity="back\GeneralBundle\Entity\Localite")
     * @ORM\OrderBy({"libelle" = "ASC"})
     */
    protected $localite;

    /**
     * @ORM\ManyToOne(targetEntity="back\GeneralBundle\Entity\Supermarche")
     * @ORM\OrderBy({"libelle" = "ASC"})
     */
    protected $supermarche;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

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
        return 'uploads/clients';
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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     *
     * @return User
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return User
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
     * Set localite
     *
     * @param \back\GeneralBundle\Entity\Localite $localite
     *
     * @return User
     */
    public function setLocalite(\back\GeneralBundle\Entity\Localite $localite = null)
    {
        $this->localite = $localite;

        return $this;
    }

    /**
     * Get localite
     *
     * @return \back\GeneralBundle\Entity\Localite
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * Get supermarche
     *
     * @return \back\GeneralBundle\Entity\Supermarche
     */
    public function getSupermarche()
    {
        return $this->supermarche;
    }

    /**
     * Set supermarche
     *
     * @param \back\GeneralBundle\Entity\Supermarche $supermarche
     *
     * @return User
     */
    public function setSupermarche(Supermarche $supermarche = null)
    {
        $this->supermarche = $supermarche;

        return $this;
    }


    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return User
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }




    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return User
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
