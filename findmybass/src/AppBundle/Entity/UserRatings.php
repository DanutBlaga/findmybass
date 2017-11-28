<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * UserRatings
 *
 * @ORM\Table(name="user_ratings", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="bassUserIdx", columns={"bassID", "userID"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRatingsRepository")
 */
class UserRatings
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
     * @var bool
     *
     * @ORM\Column(name="isThumbsUp", type="boolean")
     */
    private $isThumbsUp;

    /**
     * @var int
     * @ORM\Column(name="userID", type="integer")
     */
    private $userID;

    /**
     * @var int
     * @ORM\Column(name="bassID", type="integer")
     */
    private $bassID;

    /**
     * @var Bass
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bass")
     * @ORM\JoinColumn(name="bassID", referencedColumnName="id")
     */
    private $bass;

    /**
     * @var Users
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumn(name="userID", referencedColumnName="id")
     */
    private $user;

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
     * Set isThumbsUp
     *
     * @param boolean $isThumbsUp
     *
     * @return UserRatings
     */
    public function setIsThumbsUp($isThumbsUp)
    {
        $this->isThumbsUp = $isThumbsUp;

        return $this;
    }

    /**
     * Get isThumbsUp
     *
     * @return bool
     */
    public function getIsThumbsUp()
    {
        return $this->isThumbsUp;
    }

    /**
     * Set bassID
     *
     * @param integer $bassID
     *
     * @return UserRatings
     */
    public function setBassID($bassID)
    {
        $this->bassID = $bassID;

        return $this;
    }

    /**
     * Get bassID
     *
     * @return int
     */
    public function getBassID()
    {
        return $this->bassID;
    }

    /**
     * Set userID
     *
     * @param integer $userID
     *
     * @return UserRatings
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

    /**
     * Get userID
     *
     * @return int
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return Bass
     */
    public function getBass()
    {
        return $this->bass;
    }

    /**
     * @param Bass $bass
     */
    public function setBass($bass)
    {
        $this->bass = $bass;
    }

    /**
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Users $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

