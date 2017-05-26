<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 19/05/2017
 * Time: 11:05
 */

namespace INSEAD\TurkeyBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use INSEAD\TurkeyBundle\Entity\Answer;
use Doctrine\ORM\QueryBuilder;

class FilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Topics', EntityType::class, array(
                'class' => 'INSEAD\TurkeyBundle\Entity\Topic',
                'choice_label' => 'name',
                'label' => 'Topic',
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('nbOfResponders', IntegerType::class, array(
                'label' => 'Number of respondents wanted',
                'required' => true,
                )
            )
            ->add('locations', EntityType::class, array(
                'class' => 'INSEAD\TurkeyBundle\Entity\Demographic',
                'choice_label' => 'name',
                'label' => 'Respondent demographics',
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('gender', ChoiceType::class, [
                'choices'=> [
                    'Female/Male' => 'Female/Male',
                    'Female' =>'Female',
                    'Male' =>'Male'
                ],
            ])
            ->add('ageMin', IntegerType::class, array(
                'label' => 'Minimum age of respondent',
                'required' => true,
            ))
            ->add('ageMax', IntegerType::class, array(
                'label' => 'Maximum age of respondent',
                'required' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'INSEAD\TurkeyBundle\Entity\Filter'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'insead_turkeybundle_filter';
    }
}