<?php

namespace INSEAD\TurkeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AnswerType extends AbstractType
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
            ->add('education', null, array('required' => true))
            ->add('gender', ChoiceType::class, [
                'choices'=> [
                    'Female' =>'Female',
                    'Male' =>'Male'
            ],
            ])
            ->add('birthdate', BirthdayType::class, array(
                'placeholder' => 'Select a value', 'required' => true ))
            ->add('creditEarned', HiddenType::class)
            ->add('user', HiddenType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INSEAD\TurkeyBundle\Entity\Answer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'insead_turkeybundle_answer';
    }


}
