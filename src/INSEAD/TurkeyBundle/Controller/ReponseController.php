<?php

namespace INSEAD\TurkeyBundle\Controller;

use INSEAD\TurkeyBundle\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reponses = $em->getRepository('INSEADTurkeyBundle:Reponse')->findAll();

        return $this->render('@INSEADTurkey/reponse/index.html.twig', array(
            'reponses' => $reponses,
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
        $reponse = new Reponse();
        $form = $this->createForm('INSEAD\TurkeyBundle\Form\ReponseType', $reponse);
        $form->handleRequest($request);
        $current_user = $this->get('helper_services')->getCurrentUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reponse);

            // Script test si réponse dans blacklist
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

//            var_dump(empty($matches[0]));
//            die();
            // fin test blacklist

            if (empty($matches[0])) {
            $reponse->setAnswer($current_user);
            $em->flush();

            return $this->redirectToRoute('reponse_show', array('id' => $reponse->getId()));
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
}
