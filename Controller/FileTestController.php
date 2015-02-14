<?php

namespace Ibsweb\PersonnelBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ibsweb\PersonnelBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FileTestController extends Controller{
  /**
   * @Route("/file_test", name="file_new")
   */
  public function newAction(Request $request){
    $document = new Document();

    $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->add('delete', 'checkbox',
              array(
                'mapped' => false,
                'required' => false,
              )
            )
            ->add('save', 'submit')
            ->getForm();

    //Overwrite the form with the request data (if available)
    $form->handleRequest($request);
    //$test = $form["delete"]->getData();

    //If the form is appropriately
    if ($form->isValid()){
      $em = $this->getDoctrine()->getManager();

      $em->persist($document);
      $em->flush();

      return $this->redirect($this->generateUrl('file_new'));
    }

    return $this->render('IbswebPersonnelBundle:Document:new.html.twig',
      array(
        'form' => $form->createView(),
      )
    );
  }
  /**
   * @Route("/file_delete/{id}", name="file_delete")
   */
  public function deleteAction(Request $request, $id){
    $document = $this->getDoctrine()
      ->getRepository("IbswebPersonnelBundle:Document")
      ->find($id);
    
    $em = $this->getDoctrine()->getManager();

    $em->remove($document);
    $em->flush();

    return $this->redirect($this->generateUrl('file_new'));
    
  }
}