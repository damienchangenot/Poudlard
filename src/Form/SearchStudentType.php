<?php

namespace App\Form;

use App\Entity\House;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchStudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', SearchType::class,[
                'required' => false
            ])
            ->add('house', EntityType::class,[
                'required' => false,
                'class' => House::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('isTeacher', CheckboxType::class,[
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
