<?php

namespace JeuxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JeuxBundle\Entity\WordList;
use JeuxBundle\Form\WordListType;

/**
 * WordList controller.
 *
 * @Route("/wordlist")
 */
class WordListController extends Controller
{
    /**
     * Lists all WordList entities.
     *
     * @Route("/", name="wordlist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wordLists = $em->getRepository('JeuxBundle:WordList')->findAll();

        return $this->render('wordlist/index.html.twig', array(
            'wordLists' => $wordLists,
        ));
    }

    /**
     * Creates a new WordList entity.
     *
     * @Route("/new", name="wordlist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $wordList = new WordList();
        $form = $this->createForm('JeuxBundle\Form\WordListType', $wordList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wordList);
            $em->flush();

            return $this->redirectToRoute('wordlist_show', array('id' => $wordList->getId()));
        }

        return $this->render('wordlist/new.html.twig', array(
            'wordList' => $wordList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a WordList entity.
     *
     * @Route("/{id}", name="wordlist_show")
     * @Method("GET")
     */
    public function showAction(WordList $wordList)
    {
        $deleteForm = $this->createDeleteForm($wordList);

        return $this->render('wordlist/show.html.twig', array(
            'wordList' => $wordList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing WordList entity.
     *
     * @Route("/{id}/edit", name="wordlist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, WordList $wordList)
    {
        $deleteForm = $this->createDeleteForm($wordList);
        $editForm = $this->createForm('JeuxBundle\Form\WordListType', $wordList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wordList);
            $em->flush();

            return $this->redirectToRoute('wordlist_edit', array('id' => $wordList->getId()));
        }

        return $this->render('wordlist/edit.html.twig', array(
            'wordList' => $wordList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a WordList entity.
     *
     * @Route("/{id}", name="wordlist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, WordList $wordList)
    {
        $form = $this->createDeleteForm($wordList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wordList);
            $em->flush();
        }

        return $this->redirectToRoute('wordlist_index');
    }

    /**
     * Creates a form to delete a WordList entity.
     *
     * @param WordList $wordList The WordList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(WordList $wordList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wordlist_delete', array('id' => $wordList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
