<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 11/05/2017
 * Time: 00:18
 */

namespace INSEAD\TurkeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="INSEAD\TurkeyBundle\Repository\QuestionRepository")
 */
class Question
{
    public function __construct()
    {
        $this->dateCreate = new \Datetime();
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->question;
    }

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(name="dateCreate", type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\ManyToOne(targetEntity="INSEAD\TurkeyBundle\Entity\Asker", fetch="EAGER")
     * @ORM\JoinColumn
     */
    private $asker;

    /**
     * @ORM\OneToMany(targetEntity="INSEAD\TurkeyBundle\Entity\Reponse", cascade={"all"}, mappedBy="question")
     */
    private $reponses; // Notez le « s », une question est liée à plusieurs reponses

    /**
     * @ORM\OneToOne(targetEntity="INSEAD\TurkeyBundle\Entity\Filter", cascade={"all"})
     */
    private $filter;

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
     * Set question
     *
     * @param string $question
     *
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Question
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set asker
     *
     * @param \INSEAD\TurkeyBundle\Entity\Asker $asker
     *
     * @return Question
     */
    public function setAsker(\INSEAD\TurkeyBundle\Entity\Asker $asker = null)
    {
        $this->asker = $asker;

        return $this;
    }

    /**
     * Get asker
     *
     * @return \INSEAD\TurkeyBundle\Entity\Asker
     */
    public function getAsker()
    {
        return $this->asker;
    }

    /**
     * Add reponse
     *
     * @param \INSEAD\TurkeyBundle\Entity\Reponse $reponse
     *
     * @return Question
     */
    public function addReponse(\INSEAD\TurkeyBundle\Entity\Reponse $reponse)
    {
        $this->reponses[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse
     *
     * @param \INSEAD\TurkeyBundle\Entity\Reponse $reponse
     */
    public function removeReponse(\INSEAD\TurkeyBundle\Entity\Reponse $reponse)
    {
        $this->reponses->removeElement($reponse);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * Set filter
     *
     * @param \INSEAD\TurkeyBundle\Entity\Filter $filter
     *
     * @return Question
     */
    public function setFilter(\INSEAD\TurkeyBundle\Entity\Filter $filter = null)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return \INSEAD\TurkeyBundle\Entity\Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
