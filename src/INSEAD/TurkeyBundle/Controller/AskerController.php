<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Asker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Asker controller.
 *
 * @Route("asker")
 */
class AskerController extends Controller
{
    /**
     * Lists all asker entities.
     *
     * @Route("/", name="asker_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $askers = $em->getRepository('INSEADTurkeyBundle:Asker')->findAll();

        return $this->render('@INSEADTurkey/asker/index.html.twig', array(
            'askers' => $askers,
        ));
    }

    /**
     * Creates a new asker entity.
     *
     * @Route("/new", name="asker_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $asker = new Asker();
        $form = $this->createForm('INSEAD\TurkeyBundle\Form\AskerType', $asker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($asker);
            $em->flush();

            return $this->redirectToRoute('asker_show', array('id' => $asker->getId()));
        }

        return $this->render('@INSEADTurkey/asker/new.html.twig', array(
            'asker' => $asker,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a asker entity.
     *
     * @Route("/{id}", name="asker_show")
     * @Method("GET")
     */
    public function showAction(Asker $asker)
    {
        $deleteForm = $this->createDeleteForm($asker);

        return $this->render('@INSEADTurkey/asker/show.html.twig', array(
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
            $this->getDoctrine()->getManager()->flush();
            $current_user = $this->get('helper_services')->getCurrentUser();
            return $this->render('@INSEADTurkey/asker_answer/home.html.twig', array(
                'user' => $current_user,
                'asker' => $asker));

        }

        return $this->render('@INSEADTurkey/asker/edit.html.twig', array(
            'asker' => $asker,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a asker entity.
     *
     * @Route("/{id}", name="asker_delete")
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
