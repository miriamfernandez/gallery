<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $images = $this->getDoctrine()
                       ->getRepository('AppBundle:Item')
                       ->findAll();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array('images' => $images));
    }

    /**
     * @Route("/images/{id}", defaults={"id": 1}, requirements={
     *     "id": "\d+"
     * })
     */
    public function listAction($id)
    {
        //Aqui va el código
    }

    /**
     * @Route("/images/{slug}")
     */
    public function listNameAction($slug)
    {
        //Aqui va el código
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

    /**
     * @Route("/contact", name="contact")
     */

    public function contactAction()
    {
        return $this->render('default/contact.html.twig');
    }
}
