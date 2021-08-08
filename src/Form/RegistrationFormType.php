<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'DannyZ',
                    'pattern' => '[\w\d]{2,60}'
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Danny',
                    'pattern' => "[A-Za-zÀ-úœ'\-\s]{1,60}"
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Zuko',
                    'pattern' => "[A-Za-zÀ-úœ'\-\s]{1,60}"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe', 'attr' => [
                    'pattern' => '(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}'
                ]],
                'second_options' => ['label' => 'Confirmer', 'attr' => [
                    'pattern' => '(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}'
                ]],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['placeholder' => 'danny.zuko@gmail.com']
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '012345567889',
                    'pattern' => '\+?\(?\d{2,4}\)?[\d\s-]{3,}'
                ]
            ])
            ->add('birthDate', BirthdayType::class)
            ->add('campus', ChoiceType::class, [
                'choices' => $options['campus_list'],
                'choice_value' => function($campus) {
                    return $campus ? $campus->getId() : '';
                },
                'choice_label' => function($campus) {
                    return $campus ? $campus->getName() : '';
                }
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'ai lu et accepté les conditions d'utilisation",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Oups! Vous avez oublié de cocher la case!",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('campus_list');
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
