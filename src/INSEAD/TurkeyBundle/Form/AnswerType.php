<?php

namespace INSEAD\TurkeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnswerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('company')
            ->add('sector')
            ->add('jobFunction')
            ->add('jobLevel')
            ->add('location')
            ->add('education')
            ->add('gender', ChoiceType::class, [
                'choices'=> [
                    'Female' =>'Female',
                    'Male' =>'Male'
            ],
            ])
            ->add('birthdate', BirthdayType::class, array(
                'placeholder' => 'Select a value',))
            ->add('creditEarned')
            ->add('user');
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
