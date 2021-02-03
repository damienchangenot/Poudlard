<?php

namespace App\Form;

use App\Entity\House;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'rounded-pill'
                ]
            ])
            ->add('subject', TextType::class, [
                'attr' => [
                    'class' => 'rounded-pill'
                ]
            ])
            ->add('house', EntityType::class,[
                'class' => House::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'rounded-pill'
                ]
            ])
            ->add('pictureFile', VichImageType::class, [
                'required'      => true,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
