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

/**
 * @ORM\Entity(repositoryClass="INSEAD\TurkeyBundle\Repository\ReponseRepository")
 */
class Reponse
{

    public function __toString()
    {
        return $this->textReponse;
    }

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="textReponse", type="string", length=255)
     */
    private $textReponse;

    /**
     * @ORM\Column(name="goodReponse", type="boolean")
     */
    private $goodReponse = true;
    
    /**
     * @ORM\ManyToOne(targetEntity="INSEAD\TurkeyBundle\Entity\Question", inversedBy="reponses", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="INSEAD\TurkeyBundle\Entity\Answer", fetch="EAGER")
     * @ORM\JoinColumn
     */
    private $answer;

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
     * Set textReponse
     *
     * @param string $textReponse
     *
     * @return Reponse
     */
    public function setTextReponse($textReponse)
    {
        $this->textReponse = $textReponse;

        return $this;
    }

    /**
     * Get textReponse
     *
     * @return string
     */
    public function getTextReponse()
    {
        return $this->textReponse;
    }

    /**
     * Set goodReponse
     *
     * @param boolean $goodReponse
     *
     * @return Reponse
     */
    public function setGoodReponse($goodReponse)
    {
        $this->goodReponse = $goodReponse;

        return $this;
    }

    /**
     * Get goodReponse
     *
     * @return boolean
     */
    public function getGoodReponse()
    {
        return $this->goodReponse;
    }

    /**
     * Set question
     *
     * @param \INSEAD\TurkeyBundle\Entity\Question $question
     *
     * @return Reponse
     */
    public function setQuestion(\INSEAD\TurkeyBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \INSEAD\TurkeyBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param \INSEAD\TurkeyBundle\Entity\Answer $answer
     *
     * @return Reponse
     */
    public function setAnswer(\INSEAD\TurkeyBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \INSEAD\TurkeyBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
