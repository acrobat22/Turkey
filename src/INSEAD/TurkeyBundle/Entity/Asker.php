<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 13/05/2017
 * Time: 11:56
 */

namespace INSEAD\TurkeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
// * @ORM\Entity(repositoryClass="@INSEAD\TurkeyBundle\Entity\AskerRepository")
* @ORM\Entity
 */
class Asker
{

    public function __toString()
    {
        return $this->firstName;
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
     * @ORM\ManyToOne(targetEntity="INSEAD\TurkeyBundle\Entity\Demographic", fetch="EAGER")
     * @ORM\JoinColumn
     */
    private $location;

    /**
     * @ORM\Column(name="annual", type="integer", nullable=true)
     */
    protected $annual;

    /**
     * @ORM\Column(name="marketing", type="string", length=255, nullable=true)
     */
    protected $marketing;

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
     * @return Asker
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
     * @return Asker
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
     * @return Asker
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
     * @return Asker
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
     * @return Asker
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
     * @return Asker
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
     * Set annual
     *
     * @param integer $annual
     *
     * @return Asker
     */
    public function setAnnual($annual)
    {
        $this->annual = $annual;

        return $this;
    }

    /**
     * Get annual
     *
     * @return integer
     */
    public function getAnnual()
    {
        return $this->annual;
    }

    /**
     * Set marketing
     *
     * @param string $marketing
     *
     * @return Asker
     */
    public function setMarketing($marketing)
    {
        $this->marketing = $marketing;

        return $this;
    }

    /**
     * Get marketing
     *
     * @return string
     */
    public function getMarketing()
    {
        return $this->marketing;
    }

    /**
     * Set user
     *
     * @param \INSEAD\UserBundle\Entity\User $user
     *
     * @return Asker
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
     * @return Asker
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
