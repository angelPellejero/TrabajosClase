<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trabajo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trabajo controller.
 *
 */
class TrabajoController extends Controller
{
    /**
     * Lists all trabajo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trabajos = $em->getRepository('AppBundle:Trabajo')->findAll();

        return $this->render('trabajo/index.html.twig', array(
            'trabajos' => $trabajos,
        ));
    }

    /**
     * Creates a new trabajo entity.
     *
     */
    public function newAction(Request $request)
    {
        $trabajo = new Trabajo();
        $form = $this->createForm('AppBundle\Form\TrabajoType', $trabajo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trabajo);
            $em->flush($trabajo);

            return $this->redirectToRoute('trabajo_show', array('id' => $trabajo->getId()));
        }

        return $this->render('trabajo/new.html.twig', array(
            'trabajo' => $trabajo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trabajo entity.
     *
     */
    public function showAction(Trabajo $trabajo)
    {
        $deleteForm = $this->createDeleteForm($trabajo);

        return $this->render('trabajo/show.html.twig', array(
            'trabajo' => $trabajo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing trabajo entity.
     *
     */
    public function editAction(Request $request, Trabajo $trabajo)
    {
        $deleteForm = $this->createDeleteForm($trabajo);
        $editForm = $this->createForm('AppBundle\Form\TrabajoType', $trabajo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trabajo_edit', array('id' => $trabajo->getId()));
        }

        return $this->render('trabajo/edit.html.twig', array(
            'trabajo' => $trabajo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trabajo entity.
     *
     */
    public function deleteAction(Request $request, Trabajo $trabajo)
    {
        $form = $this->createDeleteForm($trabajo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trabajo);
            $em->flush($trabajo);
        }

        return $this->redirectToRoute('trabajo_index');
    }

    /**
     * Creates a form to delete a trabajo entity.
     *
     * @param Trabajo $trabajo The trabajo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Trabajo $trabajo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trabajo_delete', array('id' => $trabajo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
