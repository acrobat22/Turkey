<?php

namespace INSEAD\TurkeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



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
            ->add('location', EntityType::class, array(
                'class' => 'INSEAD\TurkeyBundle\Entity\Demographic',
                'choice_label' => 'name',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
            ))
            ->add('annual', null, array('label' => 'Annual revenue','required' => true))
            ->add('marketing', null, array('label' => 'Annual marketing budget','required' => true));
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
