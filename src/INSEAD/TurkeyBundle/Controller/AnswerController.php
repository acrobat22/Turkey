<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Answer controller.
 *
 * @Route("answer")
 */
class AnswerController extends Controller
{
    /**
     * Lists all answer entities.
     *
     * @Route("/", name="answer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $answers = $em->getRepository('INSEADTurkeyBundle:Answer')->findAll();

        return $this->render('@INSEADTurkey/answer/index.html.twig', array(
            'answers' => $answers,
        ));
    }

    /**
     * Finds and displays a answer entity.
     *
     * @Route("/{id}", name="answer_show")
     * @Method("GET")
     */
    public function showAction(Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);

        return $this->render('@INSEADTurkey/answer/show.html.twig', array(
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

            // Pas credit si profil incomplet
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
            return $this->render('@INSEADTurkey/asker_answer/home.html.twig', array(
                'user' => $current_user,
                'asker' => $answer));
        }

        return $this->render('@INSEADTurkey/answer/edit.html.twig', array(
            'answer' => $answer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a answer entity.
     *
     * @Route("/{id}", name="answer_delete")
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
