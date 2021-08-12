<?php

namespace App\Form;

use App\Entity\Outing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OutingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de la sortie',
                'attr' => [
                    'placeholder' => 'Choisis un titre'
                ]
            ])
            ->add('dayAndTime', DateTimeType::class, [
                'label' => 'Date et heure',
                'time_widget' => 'single_text',
                'date_widget' => 'single_text'
            ])
            ->add('closingDate', DateType::class, [
                'label' => 'Clôture des inscriptions',
                'widget' => 'single_text'
            ])
            ->add('fare', NumberType::class, [
                'label' => 'Tarif par personne',
                'attr' => [
                    'placeholder' => 'Ex : 5'
                ]
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Nombre max de participants',
                'attr' => [
                    'placeholder' => 'Ex : 20'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Décris la sortie en 3 lignes...'
                ]
            ])
            ->add('campus', ChoiceType::class, [
                'choices' => $options['campus_list'],
                'choice_value' => function($campus) {
                    return $campus ? $campus->getId() : '';
                },
                'choice_label' => function($campus) {
                    return $campus ? $campus->getName() : '';
                }
            ])
            ->add('location', LocationFormType::class)
            ->add('type', TypeFormType::class)
            ->add('outingImage', FileType::class, [
                'label' => 'Choisis une image',
                'multiple' => false,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('campus_list');
        $resolver->setDefaults([
            'data_class' => Outing::class,
        ]);
    }
}
