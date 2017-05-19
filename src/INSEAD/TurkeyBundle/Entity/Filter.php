<?php

namespace INSEAD\TurkeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filter
 *
 * @ORM\Table(name="filter")
 * @ORM\Entity(repositoryClass="INSEAD\TurkeyBundle\Repository\FilterRepository")
 */
class Filter
{
    public function __toString()
    {
        return $this->demographic;
    }

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
     * @ORM\Column(name="nbOfResponders", type="integer")
     */
    private $nbOfResponders;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var int
     *
     * @ORM\Column(name="ageMin", type="integer")
     */
    private $ageMin;

    /**
     * @var int
     *
     * @ORM\Column(name="ageMax", type="integer")
     */
    private $ageMax;

    /**
     * @ORM\ManyToMany(targetEntity="INSEAD\TurkeyBundle\Entity\Demographic", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="INSEAD\TurkeyBundle\Entity\Topic", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn
     */
    private $topic;

    //***************************************//
    //                                       //
    //           GENERATED CODE              //
    //                                       //
    //***************************************//


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nbOfResponders
     *
     * @param integer $nbOfResponders
     *
     * @return Filter
     */
    public function setNbOfResponders($nbOfResponders)
    {
        $this->nbOfResponders = $nbOfResponders;

        return $this;
    }

    /**
     * Get nbOfResponders
     *
     * @return integer
     */
    public function getNbOfResponders()
    {
        return $this->nbOfResponders;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Filter
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set ageMin
     *
     * @param integer $ageMin
     *
     * @return Filter
     */
    public function setAgeMin($ageMin)
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    /**
     * Get ageMin
     *
     * @return integer
     */
    public function getAgeMin()
    {
        return $this->ageMin;
    }

    /**
     * Set ageMax
     *
     * @param integer $ageMax
     *
     * @return Filter
     */
    public function setAgeMax($ageMax)
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    /**
     * Get ageMax
     *
     * @return integer
     */
    public function getAgeMax()
    {
        return $this->ageMax;
    }

    /**
     * Set location
     *
     * @param \INSEAD\TurkeyBundle\Entity\Demographic $location
     *
     * @return Filter
     */
    public function setLocation(\INSEAD\TurkeyBundle\Entity\Demographic $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \INSEAD\TurkeyBundle\Entity\Demographic
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set topic
     *
     * @param \INSEAD\TurkeyBundle\Entity\Topic $topic
     *
     * @return Filter
     */
    public function setTopic(\INSEAD\TurkeyBundle\Entity\Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \INSEAD\TurkeyBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
        $this->topic = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add location
     *
     * @param \INSEAD\TurkeyBundle\Entity\Demographic $location
     *
     * @return Filter
     */
    public function addLocation(\INSEAD\TurkeyBundle\Entity\Demographic $location)
    {
        $this->location[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \INSEAD\TurkeyBundle\Entity\Demographic $location
     */
    public function removeLocation(\INSEAD\TurkeyBundle\Entity\Demographic $location)
    {
        $this->location->removeElement($location);
    }

    /**
     * Add topic
     *
     * @param \INSEAD\TurkeyBundle\Entity\Topic $topic
     *
     * @return Filter
     */
    public function addTopic(\INSEAD\TurkeyBundle\Entity\Topic $topic)
    {
        $this->topic[] = $topic;

        return $this;
    }

    /**
     * Remove topic
     *
     * @param \INSEAD\TurkeyBundle\Entity\Topic $topic
     */
    public function removeTopic(\INSEAD\TurkeyBundle\Entity\Topic $topic)
    {
        $this->topic->removeElement($topic);
    }
}
