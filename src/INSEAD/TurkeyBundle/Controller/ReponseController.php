<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Reponse controller.
 *
 * @Route("/")
 */
class ReponseController extends Controller
{
    /**
     * Lists all reponse entities.
     *
     * @Route("/", name="reponse_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $idQuestion = $request->get('idQuestion');
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('INSEADTurkeyBundle:Question')->findOneBy(array('id' => $idQuestion));

        $reponses = $em->getRepository('INSEADTurkeyBundle:Reponse')->findBy(array('question' => $idQuestion));

        return $this->render('@INSEADTurkey/reponse/index.html.twig', array(
            'reponses' => $reponses,
            'question' => $question,
        ));
    }

    /**
     * Creates a new reponse entity.
     *
     * @Route("/new", name="reponse_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $idQuestion = $request->get('idQuestion');
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('INSEADTurkeyBundle:Question')->findOneBy(array('id' => $idQuestion));

        $reponse = new Reponse();
        $form = $this->createForm('INSEAD\TurkeyBundle\Form\ReponseType', $reponse);
        $form->handleRequest($request);
        $current_user = $this->get('helper_services')->getCurrentUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reponse);

            // Script test si les mots de la réponse son dans dictionary
            $words = $this->get('helper_services')->getDictionaryWord();
            $teststring = $reponse->getTextReponse();
            $nbDeMots = str_word_count($teststring);

            $pattern = '/';
            $div = '';
            foreach ($words as $word) {
                $pattern .= $div . preg_quote($word);
                $div = '|';
            }
            $pattern .= '/i';

            for ($i = 0; $i < $nbDeMots; $i++) {
                preg_match_all($pattern, $teststring, $matches);
            }

            // si pas de mots interdits, validation de l'enregistrement
            if (empty($matches[0])) {
            $reponse->setAnswer($current_user);
            $reponse->setQuestion($question);

            // mise à jour compteur Answer
            $countReponseAnswer = $reponse->getAnswer()->getCreditEarned();
            $reponse->getAnswer()->setCreditEarned(++$countReponseAnswer);

            $em->flush();

            return $this->redirectToRoute('question_index');

            } else {
                $wordsInterdits = implode(", ", $matches[0]);
                $this->get('helper_services')->setFlash('Votre réponse contient des mots interdits : '. $wordsInterdits);

                return $this->render('@INSEADTurkey/reponse/new.html.twig', array(
                    'reponse' => $reponse,
                    'form' => $form->createView(),
                ));
            }
        }

        return $this->render('@INSEADTurkey/reponse/new.html.twig', array(
            'reponse' => $reponse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reponse entity.
     *
     * @Route("/{id}/show", name="reponse_show")
     * @Method("GET")
     */
    public function showAction(Reponse $reponse)
    {
        $deleteForm = $this->createDeleteForm($reponse);

        return $this->render('@INSEADTurkey/reponse/show.html.twig', array(
            'reponse' => $reponse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reponse entity.
     *
     * @Route("/{id}/edit", name="reponse_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reponse $reponse)
    {
        $deleteForm = $this->createDeleteForm($reponse);
        $editForm = $this->createForm('INSEAD\TurkeyBundle\Form\ReponseType', $reponse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reponse_edit', array('id' => $reponse->getId()));
        }

        return $this->render('@INSEADTurkey/reponse/edit.html.twig', array(
            'reponse' => $reponse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reponse entity.
     *
     * @Route("/{id}", name="reponse_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reponse $reponse)
    {
        $form = $this->createDeleteForm($reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reponse);
            $em->flush();
        }

        return $this->redirectToRoute('reponse_index');
    }

    /**
     * Creates a form to delete a reponse entity.
     *
     * @param Reponse $reponse The reponse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reponse $reponse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reponse_delete', array('id' => $reponse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Export user en CSV.
     * @Route("/csv", name="csvExport")
     */
    public function generateCsvAction(Request $request)
    {
        $idQuestion = $request->get('idQuestion');
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('INSEADTurkeyBundle:Question')->findOneBy(array('id' => $idQuestion));
        $reponses = $em->getRepository('INSEADTurkeyBundle:Reponse')->findBy(array('question' => $idQuestion));

        $response= new StreamedResponse();
        $response->setCallback(function() use ($reponses, $question) {
            $handle = fopen('php://output','w+');
            fputcsv($handle, array('question', 'id', 'Reponse', 'Responder Company', 'Responder Sector', 'Responder Job function', 'Responder Job level', 'Responder Gender'),';');

            foreach ($reponses as $reponse) {
                fputcsv($handle, array(
                    $question->getQuestion(),
                    $reponse->getId(),
                    $reponse->getTextReponse(),
                    $reponse->getAnswer()->getCompany(),
                    $reponse->getAnswer()->getSector(),
                    $reponse->getAnswer()->getJobFunction(),
                    $reponse->getAnswer()->getJobLevel(),
                    $reponse->getAnswer()->getGender(),
                ),';');
            }
            fclose($handle);
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="listeDesReponses.csv"');
        return $response;
    }

}
