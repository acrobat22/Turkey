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
}