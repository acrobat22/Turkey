<?php

namespace INSEAD\TurkeyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AnswerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array('required' => true))
            ->add('firstName', TextType::class, array('required' => true))
            ->add('company', TextType::class, array('required' => true))
            ->add('sector', TextType::class, array('required' => true))
            ->add('jobFunction', TextType::class, array('required' => true))
            ->add('jobLevel', TextType::class, array('required' => true))
            ->add('location', EntityType::class, array(
                'class' => 'INSEAD\TurkeyBundle\Entity\Demographic',
                'choice_label' => 'name',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
            ))
            ->add('education', TextType::class, array('required' => true))
            ->add('gender', ChoiceType::class, [
                'choices'=> [
                    'Female' =>'Female',
                    'Male' =>'Male'
            ],
            ])
            ->add('birthdate', BirthdayType::class, array(
                'placeholder' => 'Select a value', 'required' => true,
                'years' => range(date('Y') -13, date('Y') -100)
            ))
            ->add('creditEarned', HiddenType::class);
    }

//https://stackoverflow.com/questions/19045199/symfony2-reverse-year-order-in-date-field

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
