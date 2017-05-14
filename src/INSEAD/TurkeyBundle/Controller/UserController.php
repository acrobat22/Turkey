<?php

namespace INSEAD\TurkeyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use INSEAD\TurkeyBundle\Entity\Asker;
use INSEAD\TurkeyBundle\Entity\Answer;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * connected
 *
 * @Route("/")
 */
class UserController extends Controller
{


    /**
     * home.
     *
     * @Route("/", name="home_connected")
     * @Method("GET")
     */
    public function homeConnectedAction()
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        return $this->render('@INSEADTurkey/asker_answer/home.html.twig', array(
            'user' => $current_user,
        ));
    }

}
