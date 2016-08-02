<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 13/06/2016
 * Time: 16:15
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ItemController extends Controller
{
    /**
     * @Route("/items/", name="gallery")
     *
     */
    public function indexAction(Request $request)
    {
        $items = $this->getDoctrine()
                      ->getRepository('AppBundle:Item')
                      ->findAll();

        return $this->render('item/index.html.twig', array('items' => $items));
    }

    /**
     * @Route("/items/list", name="items_list")
     *
     */
    public function listAction(Request $request)
    {
        $items = $this->getDoctrine()
                      ->getRepository('AppBundle:Item')
                      ->findAll();

        return $this->render('item/list.html.twig', array('items' => $items));
    }

    /**
     * @Route("/items/new", name="item_new")
     */
    public function newAction(Request $request)
    {
        $item = new Item();

        $form = $form = $this->createForm(new ItemType(), $item);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->get('app.upload_image')->upload($item);
                return $this->redirect($this->generateUrl('items_list'));
            }
        }
        return $this->render('item/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/items/edit/{item_id}", defaults={"item_id": 1}, name="item_edit")
     */
    public function editAction($item_id, Request $request)
    {
        $item = $this->getDoctrine()
                     ->getRepository('AppBundle:Item')
                     ->find($item_id);

        $form = $this->createForm(new ItemType(), $item);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->get('app.upload_image')->upload($item);
                return $this->redirect($this->generateUrl('items_list'));
            }
        }

        return $this->render('item/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     *
     * @Route("/items/delete/{item_id}", name="item_delete")
     */
    public function deleteAction($item_id)
    {
        $item = $this->getDoctrine()->getRepository('AppBundle:Item')->find($item_id);
        if (!$item) {
            throw $this->createNotFoundException('No user found for id ' . $item_id);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($item);
        $em->flush();

        $items = $this->getDoctrine()->getRepository('AppBundle:Item')->findAll();

        return $this->render('item/list.html.twig', array('items' => $items));
    }
}