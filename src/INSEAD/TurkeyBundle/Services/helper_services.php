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
        $user = $this->em->getRepository('INSEADTurkey:Asker')->findOneByUser($user_connect);
        if (empty($user)) {
            $user = $this->em->getRepository('INSEADTurkey:Answer')->findOneByUser($user_connect);
        }
        return $user;
    }
}