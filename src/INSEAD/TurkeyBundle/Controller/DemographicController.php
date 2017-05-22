<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Demographic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Demographic controller.
 * @security("has_role('ROLE_ADMIN')")
 * @Route("admin/demographic")
 */
class DemographicController extends Controller
{
    /**
     * Lists all demographic entities.
     *
     * @Route("/", name="demographic_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $demographics = $em->getRepository('INSEADTurkeyBundle:Demographic')->findAll();

        return $this->render('@INSEADTurkey/backend/demographic/index.html.twig', array(
            'demographics' => $demographics,
        ));
    }

    /**
     * Creates a new demographic entity.
     *
     * @Route("/new", name="demographic_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $demographic = new Demographic();
        $form = $this->createForm('INSEAD\TurkeyBundle\Form\DemographicType', $demographic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($demographic);
            $em->flush();

            return $this->redirectToRoute('demographic_show', array('id' => $demographic->getId()));
        }

        return $this->render('@INSEADTurkey/backend/demographic/new.html.twig', array(
            'demographic' => $demographic,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a demographic entity.
     *
     * @Route("/{id}/show", name="demographic_show")
     * @Method("GET")
     */
    public function showAction(Demographic $demographic)
    {
        $deleteForm = $this->createDeleteForm($demographic);

        return $this->render('@INSEADTurkey/backend/demographic/show.html.twig', array(
            'demographic' => $demographic,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing demographic entity.
     *
     * @Route("/{id}/edit", name="demographic_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Demographic $demographic)
    {
        $deleteForm = $this->createDeleteForm($demographic);
        $editForm = $this->createForm('INSEAD\TurkeyBundle\Form\DemographicType', $demographic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demographic_edit', array('id' => $demographic->getId()));
        }

        return $this->render('@INSEADTurkey/backend/demographic/edit.html.twig', array(
            'demographic' => $demographic,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a demographic entity.
     *
     * @Route("/{id}/delete", name="demographic_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Demographic $demographic)
    {
        $form = $this->createDeleteForm($demographic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demographic);
            $em->flush();
        }

        return $this->redirectToRoute('demographic_index');
    }

    /**
     * Creates a form to delete a demographic entity.
     *
     * @param Demographic $demographic The demographic entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Demographic $demographic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demographic_delete', array('id' => $demographic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
