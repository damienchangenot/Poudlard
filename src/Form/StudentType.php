<?php

namespace App\Form;

use App\Entity\House;
use App\Entity\Student;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'rounded-pill'
                ]
            ] )
            ->add('pictureFile', VichImageType::class, [
                'required'      => true,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'attr' => [
                    'class' => 'rounded-pill'
                ]
            ])
            ->add('isTeacher', CheckboxType::class, [
                'label' => 'Je suis un professeur',
                'attr' => [
                    'class' => 'rounded-pill'
                ],
                'required' => false,
            ])
            ->add('house', EntityType::class, [
                'class' => House::class,
                'required' => false,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'rounded-pill'
                ],
                'placeholder' => ''
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
