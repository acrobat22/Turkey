<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Answer controller.
 *
 * @Route("/")
 */
class AnswerController extends Controller
{
    /**
     * Lists all answer entities.
     * @security("has_role('ROLE_ADMIN')")
     * @Route("/", name="answer_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Mise en place pagination
        $findAnswers = $em->getRepository('INSEADTurkeyBundle:Answer')->findAll();
        $paginator  = $this->get('knp_paginator');
        $answers = $paginator->paginate($findAnswers, $request->query->getInt('page', 1), 5);

//        $answers = $em->getRepository('INSEADTurkeyBundle:Answer')->findAll();

        return $this->render('@INSEADTurkey/backend/answer/index.html.twig', array(
            'answers' => $answers,
        ));
    }

    /**
     * Finds and displays a answer entity.
     *
     * @Route("/{id}/show", name="answer_show")
     * @Method("GET")
     */
    public function showAction(Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);

        return $this->render('@INSEADTurkey/frontend/answer/show.html.twig', array(
            'answer' => $answer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing answer entity.
     *
     * @Route("/{id}/edit", name="answer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);
        $editForm = $this->createForm('INSEAD\TurkeyBundle\Form\AnswerType', $answer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $current_user = $this->get('helper_services')->getCurrentUser();

            // Gestion du bonus de + 5 si profil complet
            if ($answer->getBonusInscription() === false)
            {
                if ($answer->getLastName() === NULL
                    or $answer->getCompany() === NULL
                    or $answer->getSector() === NULL
                    or $answer->getJobFunction() === NULL
                    or $answer->getJobLevel() === NULL
                    or $answer->getLocation() === NULL
                    or $answer->getEducation() === NULL
                    or $answer->getBirthdate() === NULL
                ) {
                    // rien
                } else {
                    // mise à jour compteur Answer
                    $countReponseAnswer = $answer->getCreditEarned();
                    $answer->setCreditEarned($countReponseAnswer + 5);
                    $answer->setBonusInscription(true);
                }
            }

            $em->flush();
            return $this->render('@INSEADTurkey/frontend/asker_answer/home.html.twig', array(
                'user' => $current_user,
                'age' => $age = $this->get('helper_services')->getAgeAnswer(),
                'asker' => $answer));
        }

        return $this->render('@INSEADTurkey/frontend/answer/edit.html.twig', array(
            'answer' => $answer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a answer entity.
     * @security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="answer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Answer $answer)
    {
        $form = $this->createDeleteForm($answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($answer);
            $em->flush();
        }

        return $this->redirectToRoute('answer_index');
    }

    /**
     * Creates a form to delete a answer entity.
     *
     * @param Answer $answer The answer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Answer $answer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('answer_delete', array('id' => $answer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
