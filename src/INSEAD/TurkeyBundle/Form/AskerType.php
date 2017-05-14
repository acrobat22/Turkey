<?php

namespace INSEAD\TurkeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class AskerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', null, array('required' => true))
            ->add('firstName', null, array('required' => true))
            ->add('company', null, array('required' => true))
            ->add('sector', null, array('required' => true))
            ->add('jobFunction', null, array('required' => true))
            ->add('jobLevel', null, array('required' => true))
            ->add('location', null, array('required' => true))
            ->add('annual', null, array('required' => true))
            ->add('marketing', null, array('required' => true));
//            ->add('user');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INSEAD\TurkeyBundle\Entity\Asker'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'insead_turkeybundle_asker';
    }


}
