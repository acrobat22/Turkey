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
        return $this->gender;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->locations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->topics = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var int
     *
     * @ORM\Column(name="nbResponse", type="integer")
     */
    private $nbResponse;

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
    private $locations;

    /**
     * @ORM\ManyToMany(targetEntity="INSEAD\TurkeyBundle\Entity\Topic", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn
     */
    private $topics;

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
     * Set nbResponse
     *
     * @param integer $nbResponse
     *
     * @return Filter
     */
    public function setNbResponse($nbResponse)
    {
        $this->nbResponse = $nbResponse;

        return $this;
    }

    /**
     * Get nbResponse
     *
     * @return integer
     */
    public function getNbResponse()
    {
        return $this->nbResponse;
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
     * Add location
     *
     * @param \INSEAD\TurkeyBundle\Entity\Demographic $location
     *
     * @return Filter
     */
    public function addLocation(\INSEAD\TurkeyBundle\Entity\Demographic $location)
    {
        $this->locations[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \INSEAD\TurkeyBundle\Entity\Demographic $location
     */
    public function removeLocation(\INSEAD\TurkeyBundle\Entity\Demographic $location)
    {
        $this->locations->removeElement($location);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocations()
    {
        return $this->locations;
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
        $this->topics[] = $topic;

        return $this;
    }

    /**
     * Remove topic
     *
     * @param \INSEAD\TurkeyBundle\Entity\Topic $topic
     */
    public function removeTopic(\INSEAD\TurkeyBundle\Entity\Topic $topic)
    {
        $this->topics->removeElement($topic);
    }

    /**
     * Get topics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTopics()
    {
        return $this->topics;
    }
}
