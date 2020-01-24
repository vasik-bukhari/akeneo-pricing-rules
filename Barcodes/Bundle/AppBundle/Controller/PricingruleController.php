<?php

namespace Barcodes\Bundle\AppBundle\Controller;

use Barcodes\Bundle\AppBundle\Entity\Pricingrule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pricingrule controller.
 *
 */
class PricingruleController extends Controller
{
    /**
     * Lists all pricingrule entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pricingrules = $em->getRepository('BarcodesAppBundle:Pricingrule')->findAll();

        return $this->render('pricingrule/index.html.twig', array(
            'pricingrules' => $pricingrules,
        ));
    }

    /**
     * Creates a new pricingrule entity.
     *
     */
    public function newAction(Request $request)
    {
        $pricingrule = new Pricingrule();
        $form = $this->createForm('Barcodes\Bundle\AppBundle\Form\PricingruleType', $pricingrule);
        $form->handleRequest($request);
        // print_r($form);
        // die();
        // $request = Request::createFromGlobals();
        // echo $request->request->get('manufacturer') ."<- test ->";
        // echo "<pre>";
        // print_r($_POST);
        $post = '';
        foreach ($_POST as $key => $value) {
            $post = $key;
        }
        $post = json_decode($post);
            $pricingrule->setManufacturer($post->manufacturer);
            $pricingrule->setCategory($post->category);
            $pricingrule->setProduct($post->product);
            $pricingrule->setPricetype('PRICE');
            $pricingrule->setOperator($post->operator);
            $pricingrule->setValue($post->value);
            $pricingrule->setChannel($post->channel);
            $pricingrule->setCreatedAt();
            $pricingrule->setUpdatedAt();
            $em = $this->getDoctrine()->getManager();
            $em->persist($pricingrule);
            $em->flush();
            return $this->redirectToRoute('barcodes_pricingrules_show', array('id' => $pricingrule->getId()));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pricingrule);
            $em->flush();

            return $this->redirectToRoute('barcodes_pricingrules_show', array('id' => $pricingrule->getId()));
        }

        return $this->render('pricingrule/new.html.twig', array(
            'pricingrule' => $pricingrule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pricingrule entity.
     *
     */
    public function showAction(Pricingrule $pricingrule)
    {
        $deleteForm = $this->createDeleteForm($pricingrule);

        return $this->render('pricingrule/show.html.twig', array(
            'pricingrule' => $pricingrule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pricingrule entity.
     *
     */
    public function editAction(Request $request, Pricingrule $pricingrule)
    {
        $deleteForm = $this->createDeleteForm($pricingrule);
        $editForm = $this->createForm('Barcodes\Bundle\AppBundle\Form\PricingruleType', $pricingrule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('barcodes_pricingrules_edit', array('id' => $pricingrule->getId()));
        }

        return $this->render('pricingrule/edit.html.twig', array(
            'pricingrule' => $pricingrule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pricingrule entity.
     *
     */
    public function deleteAction(Request $request, Pricingrule $pricingrule)
    {
        $form = $this->createDeleteForm($pricingrule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pricingrule);
            $em->flush();
        }

        return $this->redirectToRoute('barcodes_pricingrules_index');
    }

    /**
     * Creates a form to delete a pricingrule entity.
     *
     * @param Pricingrule $pricingrule The pricingrule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pricingrule $pricingrule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('barcodes_pricingrules_delete', array('id' => $pricingrule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
