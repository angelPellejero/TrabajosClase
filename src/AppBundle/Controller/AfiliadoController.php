<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Afiliado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Afiliado controller.
 *
 */
class AfiliadoController extends Controller
{
    /**
     * Lists all afiliado entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $afiliados = $em->getRepository('AppBundle:Afiliado')->findAll();

        return $this->render('afiliado/index.html.twig', array(
            'afiliados' => $afiliados,
        ));
    }

    /**
     * Creates a new afiliado entity.
     *
     */
    public function newAction(Request $request)
    {
        $afiliado = new Afiliado();
        $form = $this->createForm('AppBundle\Form\AfiliadoType', $afiliado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($afiliado);
            $em->flush($afiliado);

            return $this->redirectToRoute('afiliado_show', array('id' => $afiliado->getId()));
        }

        return $this->render('afiliado/new.html.twig', array(
            'afiliado' => $afiliado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a afiliado entity.
     *
     */
    public function showAction(Afiliado $afiliado)
    {
        $deleteForm = $this->createDeleteForm($afiliado);

        return $this->render('afiliado/show.html.twig', array(
            'afiliado' => $afiliado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing afiliado entity.
     *
     */
    public function editAction(Request $request, Afiliado $afiliado)
    {
        $deleteForm = $this->createDeleteForm($afiliado);
        $editForm = $this->createForm('AppBundle\Form\AfiliadoType', $afiliado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('afiliado_edit', array('id' => $afiliado->getId()));
        }

        return $this->render('afiliado/edit.html.twig', array(
            'afiliado' => $afiliado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a afiliado entity.
     *
     */
    public function deleteAction(Request $request, Afiliado $afiliado)
    {
        $form = $this->createDeleteForm($afiliado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($afiliado);
            $em->flush($afiliado);
        }

        return $this->redirectToRoute('afiliado_index');
    }

    /**
     * Creates a form to delete a afiliado entity.
     *
     * @param Afiliado $afiliado The afiliado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Afiliado $afiliado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('afiliado_delete', array('id' => $afiliado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
