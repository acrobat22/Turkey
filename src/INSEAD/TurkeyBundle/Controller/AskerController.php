<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Asker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Asker controller.
 *
 * @Route("/")
 */
class AskerController extends Controller
{
    /**
     * Lists all asker entities.
     * @security("has_role('ROLE_ADMIN')")
     * @Route("/", name="asker_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Mise en place pagination
        $findAskers = $em->getRepository('INSEADTurkeyBundle:Asker')->findAll();
        $paginator  = $this->get('knp_paginator');
        $askers = $paginator->paginate($findAskers, $request->query->getInt('page', 1), 5);

        return $this->render('@INSEADTurkey/backend/asker/index.html.twig', array(
            'askers' => $askers,
        ));
    }

    /**
     * Update premium asker.
     *
     * @Route("/{id}/premium", name="asker_premium")
     * @Method("GET")
     */
    public function premiumAction(Asker $asker)
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        $em = $this->getDoctrine()->getManager();

        $asker->getUser()->setRoles(array('ROLE_ASKER_PREMIUM'));
        $em->flush();

        return $this->render('@INSEADTurkey/frontend/asker_answer/home.html.twig', array(
            'askers' => $asker,
            'user' => $current_user,
        ));
    }

    /**
     * Update premium asker.
     *
     * @Route("/{id}/basic", name="asker_basic")
     * @Method("GET")
     */
    public function basicAction(Asker $asker)
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        $em = $this->getDoctrine()->getManager();
        $asker->getUser()->setRoles(array('ROLE_ASKER'));
        $em->flush();

        return $this->render('@INSEADTurkey/frontend/asker_answer/home.html.twig', array(
            'askers' => $asker,
            'user' => $current_user,
        ));
    }

    /**
     * Finds and displays a asker entity.
     *
     * @Route("/{id}/show", name="asker_show")
     * @Method("GET")
     */
    public function showAction(Asker $asker)
    {
        $deleteForm = $this->createDeleteForm($asker);

        return $this->render('@INSEADTurkey/frontend/asker/show.html.twig', array(
            'asker' => $asker,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing asker entity.
     *
     * @Route("/{id}/edit", name="asker_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Asker $asker)
    {
        $deleteForm = $this->createDeleteForm($asker);
        $editForm = $this->createForm('INSEAD\TurkeyBundle\Form\AskerType', $asker);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $current_user = $this->get('helper_services')->getCurrentUser();
            $em->flush();
            return $this->render('@INSEADTurkey/frontend/asker_answer/home.html.twig', array(
                'user' => $current_user,
                'age' => $age = $this->get('helper_services')->getAgeAnswer(),
                'asker' => $asker));
        }

        return $this->render('@INSEADTurkey/frontend/asker/edit.html.twig', array(
            'asker' => $asker,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a asker entity.
     * @security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="asker_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Asker $asker)
    {
        $form = $this->createDeleteForm($asker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asker);
            $em->flush();
        }

        return $this->redirectToRoute('asker_index');
    }

    /**
     * Creates a form to delete a asker entity.
     *
     * @param Asker $asker The asker entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Asker $asker)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asker_delete', array('id' => $asker->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
