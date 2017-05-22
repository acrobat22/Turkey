<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 13/05/2017
 * Time: 14:18
 */

namespace INSEAD\UserBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Asker;
use INSEAD\TurkeyBundle\Entity\Answer;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\RegistrationController as BaseRegistrationController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
/**
 * Question controller.
 *
 * @Route("/")
 */
class RegistrationController extends BaseRegistrationController
{
    /**
     * inscription.
     *
     * @Route("/", name="insead_inscription")
     * @Method("GET")
     */
    public function inscriptionAction()
    {
        return $this->render("@INSEADTurkey/homepage.html.twig");
    }

    /**
     * register.
     *
     * @Route("/{type}", name="register")
     * @Method("GET")
     */
    public function registerAction(Request $request)
    {
        // Récupération Asker ou Answer envoyer par page inscription.html.twig
        $type = $request->attributes->get('type');

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                // Si user type ASKER,
                if ($type == 'asker'){
                    $user->setRoles(['ROLE_ASKER']);
                    $asker = new Asker();
                    $asker->setUser($user);
                    $em->persist($asker);
                    $em->persist($user);
                }
                // Si user type ANSWER,
                elseif ($type == 'answer'){
                    $user->setRoles(['ROLE_ANSWER']);
                    $answer = new Answer();
                    $answer->setUser($user);
                    $em->persist($answer);
                    $em->persist($user);
                }
                $em->flush();
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse('@INSEADTurkey/asker_answer/newAsker_answer.html.twig', array(
            'form' => $form->createView(),
            'type' => $type
        ));

    }

    /**
     * comfimed. Tell the user his account is now confirmed
     *
     * @Route("/{type}", name="registration_confirmed")
     * @Method("GET")
     */
//fos_user_registration_confirmed
    public function confirmedAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $this->get('helper_services')->setFlash('Welcome '. $user->getUsername() .'!');

        /* récupération du user current*/
        $userByType = $this->get('helper_services')->getCurrentUser() ;
        /* récupération id pour parametre url */
        $idUser = $userByType->getId();

        // Redirection en fonction du role du user
        if ($user->getRoles()[0] == "ROLE_ASKER") {
            return $this->redirect($this->generateUrl('asker_edit', array('id' => $idUser)));

        } elseif ($user->getRoles()[0] == "ROLE_ANSWER") {
            $this->get('helper_services')->setFlash('Gagné un crédit de 5 cents, si vous compléter votre profil');

//            return $this->redirect($this->generateUrl('answer_edit', array('id' => $idUser)));

            return $this->redirectToRoute('home_connected');
        }
    }


}