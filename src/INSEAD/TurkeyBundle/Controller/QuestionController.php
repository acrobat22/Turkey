<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Question;
use INSEAD\TurkeyBundle\Entity\Asker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Question controller.
 *
 * @Route("/")
 */
class QuestionController extends Controller
{
    /**
     * Lists all question entities.
     *
     * @Route("/", name="question_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        $idCurrentUser = $current_user->getId();
        $em = $this->getDoctrine()->getManager();

        if (($current_user->getUser()->getRoles()[0] == "ROLE_ASKER") or ($current_user->getUser()->getRoles()[0] == "ROLE_ASKER_PREMIUM") ) {
            $questions = $em->getRepository('INSEADTurkeyBundle:Question')->findBy(array('asker' =>$idCurrentUser));
        } elseif ($current_user->getUser()->getRoles()[0] == "ROLE_ANSWER") {
            $questions = $em->getRepository('INSEADTurkeyBundle:Question')->findAll();
        }

        /* Gestion nombre de réponse par question */
        $nbReponse = array();

        foreach ($questions as $question)
        {
            $nbReponse[$question->getId()] = count($question->getReponses());
        }

        return $this->render('@INSEADTurkey/frontend/question/index.html.twig', array(
            'user' => $current_user,
            'questions' => $questions,
            'nbReponse' => $nbReponse,
        ));
    }

    /**
     * Lists all question entities.
     *
     * @Route("/answer", name="question_index_answer")
     * @Method("GET")
     */
    public function indexForAnswerAction()
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        $age = $this->get('helper_services')->getAgeAnswer();
        $em = $this->getDoctrine()->getManager();

        $questionsWithFilter = $em->getRepository('INSEADTurkeyBundle:Question')->getQuestionWithFilter();
        $questionsWithOutFilter = $em->getRepository('INSEADTurkeyBundle:Question')->getQuestionWithoutFilter();
        return $this->render('@INSEADTurkey/frontend/question/indexForAnswer.html.twig', array(
            'questionWithFilter' => $questionsWithFilter,
            'questionsWithOutFilter' => $questionsWithOutFilter,
            'user' => $current_user,
            'age' => $age,
        ));
    }

    /**
     * Lists all question entities.
     *
     * @Route("/random", name="question_random_answer")
     * @Method("GET")
     */
    public function RandomForAnswerAction()
    {
        $current_user = $this->get('helper_services')->getCurrentUser();
        $idAnswer = $current_user->getId();
        $age = $this->get('helper_services')->getAgeAnswer();

        $em = $this->getDoctrine()->getManager();
        $quesWOF = $em->getRepository('INSEADTurkeyBundle:Question')->getQuestionNonReponduByAnswerWithFilter($idAnswer);

        // Isole location à partir des questions non répondus du answer
        $arrayTransit1 = array();
        foreach ($quesWOF as $question) {
            foreach ($question->getFilter()->getLocations() as $location) {
                if ($location == $current_user->getLocation()) {
                    $arrayTransit1[] = $question;
                }
            }
        }

        // Isole gender à partir des questions non répondus du answer
        $arrayTransit2 = array();
        foreach ($arrayTransit1 as $question) {
            if ($question->getFilter()->getGender() == $current_user->getGender() or $question->getFilter()->getGender() == 'Female/Male') {
                $arrayTransit2[] = $question;
            }
        }

        // Isole age à partir des questions non répondus du answer
        $QuestionsMatched = array();
        foreach ($arrayTransit2 as $question) {
            if (($question->getFilter()->getAgeMin() <= $age)
                and ($age <= $question->getFilter()->getAgeMax()))
            {
                $QuestionsMatched[] = $question;
            }
        }

        // Questions NON Premium
        $questionsWithOutFilter = $em->getRepository('INSEADTurkeyBundle:Question')->getQuestionNonReponduByAnswerWithOutFilter($idAnswer);

        foreach ($questionsWithOutFilter as $question) {
            $QuestionsMatched[] = $question;
        }

        // Test si pas de valeur en retour
        if (!empty($QuestionsMatched)) {
            $randomQuestion = $QuestionsMatched[array_rand($QuestionsMatched)];
        } else {
            $randomQuestion = '';
        }

        return $this->render('@INSEADTurkey/frontend/question/randomQuestion.html.twig', array(
            'user' => $current_user,
            'random' => $randomQuestion,
        ));
    }


    /**
     * Creates a new question entity.
     *
     * @Route("/new", name="question_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm('INSEAD\TurkeyBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        $current_user = $this->get('helper_services')->getCurrentUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $question->setAsker($current_user);
            if ($question->getFilter() == null) {
                //
            } else {
                $question->getFilter()->setNbResponse(0);
            }
            $em->flush();

            return $this->redirectToRoute('question_index');
        }

        return $this->render('@INSEADTurkey/frontend/question/new.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
            'user' => $current_user,
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     * @Route("/{id}/show", name="question_show")
     * @Method("GET")
     */
    public function showAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);

        return $this->render('@INSEADTurkey/frontend/question/show.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("/{id}/edit", name="question_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('INSEAD\TurkeyBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_index');
        }

        return $this->render('@INSEADTurkey/frontend/question/edit.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a question entity.
     * @security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="question_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Question $question)
    {
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }

        return $this->redirectToRoute('question_index');
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('question_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
