<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 13/05/2017
 * Time: 11:57
 */

namespace INSEAD\TurkeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
// * @ORM\Entity(repositoryClass="@INSEAD\TurkeyBundle\Entity\AnswerRepository")
 * @ORM\Entity
 */
class Answer
{
    public function __construct()
    {
        $this->creditEarned = 0;
    }

    public function __toString()
    {
        return $this->lastName;
    }

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="INSEAD\UserBundle\Entity\User", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn
     */
    private $user;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    /**
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    protected $company;

    /**
     * @ORM\Column(name="sector", type="string", length=255, nullable=true)
     */
    protected $sector;

    /**
     * @ORM\Column(name="job_function", type="string", length=255, nullable=true)
     */
    protected $jobFunction;

    /**
     * @ORM\Column(name="job_level", type="string", length=255, nullable=true)
     */
    protected $jobLevel;

    /**
     * @ORM\Column(name="education", type="string", length=255, nullable=true)
     */
    protected $education;

    /**
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected $birthdate;

    /**
     * @ORM\Column(name="credit_earned", type="integer")
     */
    protected $creditEarned;

    /**
     * @ORM\Column(name="bonus_inscription", type="boolean")
     */
    protected $bonusInscription = false;

    /**
     * @ORM\ManyToOne(targetEntity="INSEAD\TurkeyBundle\Entity\Demographic", fetch="EAGER")
     * @ORM\JoinColumn
     */
    private $location;

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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Answer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Answer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Answer
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set sector
     *
     * @param string $sector
     *
     * @return Answer
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set jobFunction
     *
     * @param string $jobFunction
     *
     * @return Answer
     */
    public function setJobFunction($jobFunction)
    {
        $this->jobFunction = $jobFunction;

        return $this;
    }

    /**
     * Get jobFunction
     *
     * @return string
     */
    public function getJobFunction()
    {
        return $this->jobFunction;
    }

    /**
     * Set jobLevel
     *
     * @param string $jobLevel
     *
     * @return Answer
     */
    public function setJobLevel($jobLevel)
    {
        $this->jobLevel = $jobLevel;

        return $this;
    }

    /**
     * Get jobLevel
     *
     * @return string
     */
    public function getJobLevel()
    {
        return $this->jobLevel;
    }

    /**
     * Set education
     *
     * @param string $education
     *
     * @return Answer
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Answer
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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Answer
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set creditEarned
     *
     * @param integer $creditEarned
     *
     * @return Answer
     */
    public function setCreditEarned($creditEarned)
    {
        $this->creditEarned = $creditEarned;

        return $this;
    }

    /**
     * Get creditEarned
     *
     * @return integer
     */
    public function getCreditEarned()
    {
        return $this->creditEarned;
    }

    /**
     * Set bonusInscription
     *
     * @param boolean $bonusInscription
     *
     * @return Answer
     */
    public function setBonusInscription($bonusInscription)
    {
        $this->bonusInscription = $bonusInscription;

        return $this;
    }

    /**
     * Get bonusInscription
     *
     * @return boolean
     */
    public function getBonusInscription()
    {
        return $this->bonusInscription;
    }

    /**
     * Set user
     *
     * @param \INSEAD\UserBundle\Entity\User $user
     *
     * @return Answer
     */
    public function setUser(\INSEAD\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \INSEAD\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set location
     *
     * @param \INSEAD\TurkeyBundle\Entity\Demographic $location
     *
     * @return Answer
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
}
