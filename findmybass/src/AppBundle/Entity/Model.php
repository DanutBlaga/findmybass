<?php

namespace AppBundle\Entity;

use AppBundle\Utils\StringNormalizer;
use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Model
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
     * @ORM\Column(name="MakeID", type="integer")
     */
    private $makeID;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="normalized_name", type="string", length=255)
     */
    private $normalizedName;

    /**
     * @var string
     *
     * @ORM\Column(name="PicturePath", type="string", length=255, nullable=true)
     */
    private $picturePath;

    /**
     * @var Make
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Make", inversedBy="models")
     * @ORM\JoinColumn(name="MakeID", referencedColumnName="id")
     */
    private $make;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function ensureNormalizedName(){

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
     * Set makeID
     *
     * @param integer $makeID
     *
     * @return Model
     */
    public function setMakeID($makeID)
    {
        $this->makeID = $makeID;

        return $this;
    }

    /**
     * Get makeID
     *
     * @return int
     */
    public function getMakeID()
    {
        return $this->makeID;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Model
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
     * Set description
     *
     * @param string $description
     *
     * @return Model
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
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Model
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
     * @return Make
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @param Make $makeEntity
     * @return $this
     */
    public function setMake($makeEntity) {
        $this->make = $makeEntity;

        return $this;
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

