<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 13/05/2017
 * Time: 15:56
 */

namespace INSEAD\TurkeyBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use INSEAD\UserBundle\Entity\User;
use INSEAD\TurkeyBundle\Entity\Dictionary;

class helper_services
{
    protected $em;
    protected $container;

    // We need to inject this variables later.
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    /**
     * Return current user
     *
     */
    public function getCurrentUser(){
        $user_connect = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $this->em->getRepository('INSEADTurkeyBundle:Asker')->findOneByUser($user_connect);
        if (empty($user)) {
            $user = $this->em->getRepository('INSEADTurkeyBundle:Answer')->findOneByUser($user_connect);
        }
        return $user;
    }

    /**
     * Return sous forme de tableau les mots dans Dictionary
     *
     */
    public function getDictionaryWord () {
        $dictionaryWordAllData = $this->em->getRepository('INSEADTurkeyBundle:Dictionary')->findAll();
        $dictionaryWord = array();
        foreach ($dictionaryWordAllData as $word) {
            $dictionaryWord[] = $word->getWord();
        }

        return $dictionaryWord;
    }

    /**
     * Set Flash Message
     */
    public function setFlash($value)
    {
        $this->container->get('session')->getFlashBag()->set('notif', $value);
    }


    /**
     * Return age answer current
     */
    public function getAgeAnswer() {

        $current_user = $this->getCurrentUser();

        if (($current_user->getUser()->getRoles()[0] == "ROLE_ASKER") or ($current_user->getUser()->getRoles()[0] == "ROLE_ASKER_PREMIUM")) {
            $age = "";
        } elseif ($current_user->getUser()->getRoles()[0] == "ROLE_ANSWER") {
            $today = new \DateTime();
            $birthdate = $current_user->getBirthdate();
            $age = $today->diff($birthdate, true)->y;
        } elseif ($current_user->getUser()->getRoles()[0] == "ROLE_ANSWER" and $current_user->getUser()->getBirthdate('NULL')) {
            $age = "";
        }
        return $age;
    }
}