<?php

namespace INSEAD\TurkeyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use INSEAD\TurkeyBundle\Entity\Asker;
use INSEAD\TurkeyBundle\Entity\Answer;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
//    /**
//     * @Route("/")
//     */
//    public function indexAction()
//    {
//        return $this->render('INSEADUserBundle:Default:index.html.twig');
//    }

    /**
     * home.
     *
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function homeAction()
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        return $this->render('@INSEADTurkey/asker_answer/home.html.twig', array(
            'user' => $current_user,
        ));
    }

}
