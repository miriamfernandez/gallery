<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('path', 'file',array(
                'data_class' => null
            ))
            ->add('save', 'submit', array('label' => 'Guardar'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class' => 'AppBundle\Entity\Item'
                               ));
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}
