<?php

namespace App\Form;

use App\Entity\Outing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
                    'placeholder' => 'Choisis un titre',
                    'pattern' => '[\w\d]{2,100}'
                ]
            ])
            ->add('dayAndTime', DateTimeType::class, [
                'label' => 'Date et heure'
            ])
            ->add('closingDate', DateTimeType::class, [
            'label' => 'Clôture des inscriptions'
            ])
            ->add('fare', NumberType::class, [
                'label' => 'Tarif par personne'
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Nombre max de participants'
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
            ->add('type', ChoiceType::class, [
                'required' => false,
                'choices' => $options['type_list'],
                'choice_value' => function($type) {
                    return $type ? $type->getId() : '';
                },
                'choice_label' => function($type) {
                    return $type ? $type->getName() : '';
                }
            ])
            ->add('type', TypeFormType::class, [
                'required' => false
            ])
            ->add('outingImage', FileType::class, [
                'label' => 'Choisis une image',
                'multiple' => false,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['campus_list', 'type_list']);
        $resolver->setDefaults([
            'data_class' => Outing::class,
        ]);
    }
}
