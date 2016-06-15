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
            ->add('name','text', array('label' => 'Your name'))
            ->add('email','text', array('label' => 'Your email'))
            ->add('save', 'submit', array('label' => 'Guardar'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class' => 'AppBundle\Entity\User',
                                   'cascade_validation' => true
                               ));
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}