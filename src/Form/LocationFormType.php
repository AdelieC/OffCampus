<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Ex : Caen',
                    'pattern' => '[\w]{2,100}'
                ]
            ])
            ->add('zip', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Ex : 14000'
                ]
            ])
            ->add('street', TextType::class, [
                'label' => 'Nom de rue',
                'attr' => [
                    'placeholder' => 'Ex : Rue des Pommiers'
                ]
            ])
            ->add('streetNb', TextType::class, [
                'label' => 'Numéro de rue',
                'attr' => [
                    'placeholder' => 'Ex : 2bis'
                ]
            ])
            ->add('place',TextType::class, [
                'label' => "Lieu-Dit ou nom de l'endroit",
                'attr' => [
                    'placeholder' => 'Ex : Brasserie des Pommiers'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
