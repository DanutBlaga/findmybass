<?php

namespace AppBundle\Entity;

use AppBundle\Utils\StringNormalizer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Make
 *
 * @ORM\Table(name="make")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MakeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Make
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
     * @ORM\Column(name="Name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="normalized_name", type="string", length=255, unique=true)
     */
    private $normalizedName;

    /**
     * @var string
     *
     * @ORM\Column(name="PicturePath", type="string", length=255, nullable=true)
     */
    private $picturePath;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Model", mappedBy="make")
     */
    private $models;

    public function __construct(){
        $this->models = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function ensureNormalizedName() {
        $this->normalizedName = StringNormalizer::normalizeName($this->name);
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
     * Set name
     *
     * @param string $name
     *
     * @return Make
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
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Make
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    /**
     * Get picturePath
     *
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Make
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return ArrayCollection
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @return string
     */
    public function getNormalizedName()
    {
        if ($this->normalizedName == null) {
            $this->ensureNormalizedName();
        }

        return $this->normalizedName;
    }
}

