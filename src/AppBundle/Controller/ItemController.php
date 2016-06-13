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
class ItemsController  extends Controller
{
    /**
     * @Route("/images/", name="gallery")
     *
     */
    public function showAction(Request $request)
    {
        $images = $this->getDoctrine()
                       ->getRepository('AppBundle:Item')
                       ->findAll();

        return $this->render('default/galeria.html.twig', array('images' => $images));
    }
    
    /**
     * @Route("/addItems", name="addItems")
     */
    public function addItemsAction(Request $request)
    {
        $item = new Item();

        $form = $form = $this->createForm(new ItemType(), $item);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {

                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $item->getPath();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->container->getParameter('image_directory'),
                    $fileName
                );

                $item->setPath($fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($item);
                $em->flush();

                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        return $this->render('default/add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/updateItem/{item_id}", defaults={"item_id": 1}, name="_updateItem")
     */
    public function updateItemAction($item_id,Request $request)
    {
        $item = $this->getDoctrine()
                     ->getRepository('AppBundle:Item')
                     ->find($item_id);

        $form = $this->createForm(new ItemType(), $item);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {

                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $item->getPath();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->container->getParameter('image_directory'),
                    $fileName
                );

                $item->setPath($fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($item);
                $em->flush();

                return $this->redirect($this->generateUrl('homepage'));

            }
        }

        return $this->render('default/update.html.twig', array('form' => $form->createView()));
    }

}