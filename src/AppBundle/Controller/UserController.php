<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 13/06/2016
 * Time: 16:18
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/{_locale}/users/", name="users_list", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es"})
     */
    public function listAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/{_locale}/users/new", name="user_new", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es"})
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

                return $this->render('user/index.html.twig', array('users' => $users));
            }
        }

        return $this->render('user/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{_locale}/users/edit/{user_id}", name="user_edit", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es"})
     */

    public function editAction($user_id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($user_id);
        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

                return $this->render('user/index.html.twig', array('users' => $users));
            }
        }
        return $this->render('user/edit.html.twig', array('form' => $form->createView(), 'user' => $user));
    }

    /**
     * @Route("/{_locale}/users/delete/{user_id}",name="user_delete", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es"})
     */

    public function deleteAction($user_id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($user_id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $user_id);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($user);
        $em->flush();

        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/{_locale}/register", name="register_new", defaults={"_locale" = "es"}, requirements={"_locale" = "en|es"})
     *
     */
    public function newRegisterAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $user->setRoles(array('ROLE_USER'));
                $user->setIsActive(true);
                $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT, array('cost' => 13)));
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('login');
            }
        }

        return $this->render('user/register.html.twig', array('form' => $form->createView()));
    }
}