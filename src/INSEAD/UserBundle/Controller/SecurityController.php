<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 25/04/2017
 * Time: 18:58
 */

namespace INSEAD\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{

}