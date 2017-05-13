<?php

namespace INSEAD\TurkeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('last_name')->add('firstName')->add('company')->add('sector')->add('jobFunction')->add('jobLevel')->add('location')->add('annual')->add('marketing')->add('user');
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
