<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Dictionary;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dictionary controller.
 *
 * @Route("/")
 */
class DictionaryController extends Controller
{
    /**
     * Lists all dictionary entities.
     *
     * @Route("/", name="dictionary_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dictionaries = $em->getRepository('INSEADTurkeyBundle:Dictionary')->findAll();

        return $this->render('@INSEADTurkey/dictionary/index.html.twig', array(
            'dictionaries' => $dictionaries,
        ));
    }

    /**
     * Creates a new dictionary entity.
     *
     * @Route("/new", name="dictionary_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dictionary = new Dictionary();
        $form = $this->createForm('INSEAD\TurkeyBundle\Form\DictionaryType', $dictionary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dictionary);
            $em->flush();

            return $this->redirectToRoute('dictionary_index');
        }

        return $this->render('@INSEADTurkey/dictionary/new.html.twig', array(
            'dictionary' => $dictionary,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dictionary entity.
     *
     * @Route("/{id}", name="dictionary_show")
     * @Method("GET")
     */
    public function showAction(Dictionary $dictionary)
    {
        $deleteForm = $this->createDeleteForm($dictionary);

        return $this->render('@INSEADTurkey/dictionary/show.html.twig', array(
            'dictionary' => $dictionary,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dictionary entity.
     *
     * @Route("/{id}/edit", name="dictionary_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dictionary $dictionary)
    {
        $deleteForm = $this->createDeleteForm($dictionary);
        $editForm = $this->createForm('INSEAD\TurkeyBundle\Form\DictionaryType', $dictionary);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dictionary_index');
        }

        return $this->render('@INSEADTurkey/dictionary/edit.html.twig', array(
            'dictionary' => $dictionary,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dictionary entity.
     *
     * @Route("/{id}", name="dictionary_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dictionary $dictionary)
    {
        $form = $this->createDeleteForm($dictionary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dictionary);
            $em->flush();
        }

        return $this->redirectToRoute('dictionary_index');
    }

    /**
     * Creates a form to delete a dictionary entity.
     *
     * @param Dictionary $dictionary The dictionary entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dictionary $dictionary)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dictionary_delete', array('id' => $dictionary->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
