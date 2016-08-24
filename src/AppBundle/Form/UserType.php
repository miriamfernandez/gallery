<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 13/06/2016
 * Time: 16:20
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Name'))
            ->add('email', 'text', array('label' => 'email'))
            ->add('password', 'password', array('label' => 'Password'))
            ->add(
                'roles', 'choice', [
                           'choices'  => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER'],
                           'expanded' => true,
                           'multiple' => true,
                       ]
            )
            ->add('isActive', 'checkbox', array('label' => 'Active', 'required' => false))
            ->add('save', 'submit', array('label' => 'Guardar'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class'         => 'AppBundle\Entity\User',
                                   'cascade_validation' => true
                               ));
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}