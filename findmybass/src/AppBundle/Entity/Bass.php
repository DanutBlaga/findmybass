<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bass
 *
 * @ORM\Table(name="bass")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BassRepository")
 */
class Bass
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
     * @var int
     *
     * @ORM\Column(name="ModelID", type="integer")
     */
    private $modelID;

    /**
     * @var int
     *
     * @ORM\Column(name="Year", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="ManufacturingPlace", type="string", length=255, nullable=true)
     */
    private $manufacturingPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="CurrentLocation", type="string", length=255, nullable=true)
     */
    private $currentLocation;

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
     * @var int
     *
     * @ORM\Column(name="Rating", type="integer")
     */
    private $rating = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="EditDate", type="datetime")
     */
    private $editDate;

    /**
     * @var int
     *
     * @ORM\Column(name="UserID", type="integer", nullable=false)
     */
    private $userID;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users", inversedBy="basses")
     * @ORM\JoinColumn(name="UserID", referencedColumnName="id")
     */
    private $userEntity;

    /**
     * @var Make
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Make")
     * @ORM\JoinColumn(name="MakeID", referencedColumnName="id")
     */
    private $make;



    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Model")
     * @ORM\JoinColumn(name="ModelID", referencedColumnName="id")
     */
    private $model;



    private $makeName;
    private $modelName;


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
     * @return Bass
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
     * Set modelID
     *
     * @param integer $modelID
     *
     * @return Bass
     */
    public function setModelID($modelID)
    {
        $this->modelID = $modelID;

        return $this;
    }

    /**
     * Get modelID
     *
     * @return int
     */
    public function getModelID()
    {
        return $this->modelID;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Bass
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set manufacturingPlace
     *
     * @param string $manufacturingPlace
     *
     * @return Bass
     */
    public function setManufacturingPlace($manufacturingPlace)
    {
        $this->manufacturingPlace = $manufacturingPlace;

        return $this;
    }

    /**
     * Get manufacturingPlace
     *
     * @return string
     */
    public function getManufacturingPlace()
    {
        return $this->manufacturingPlace;
    }

    /**
     * Set currentLocation
     *
     * @param string $currentLocation
     *
     * @return Bass
     */
    public function setCurrentLocation($currentLocation)
    {
        $this->currentLocation = $currentLocation;

        return $this;
    }

    /**
     * Get currentLocation
     *
     * @return string
     */
    public function getCurrentLocation()
    {
        return $this->currentLocation;
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Bass
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
     * @return Bass
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
     * Set rating
     *
     * @param integer $rating
     *
     * @return Bass
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Bass
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set editDate
     *
     * @param \DateTime $editDate
     *
     * @return Bass
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;

        return $this;
    }

    /**
     * Get editDate
     *
     * @return \DateTime
     */
    public function getEditDate()
    {
        return $this->editDate;
    }

    /**
     * @return Make
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @param mixed $modelName
     */
    public function setModelName($modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @return mixed
     */
    public function getMakeName()
    {
        return $this->makeName;
    }

    /**
     * @param mixed $makeName
     */
    public function setMakeName($makeName)
    {
        $this->makeName = $makeName;
    }

    /**
     * @return Users
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param Users $userEntity
     */
    public function setUserEntity($userEntity)
    {
        $this->userEntity = $userEntity;
    }

    /**
     * @return int
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param int $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
}

