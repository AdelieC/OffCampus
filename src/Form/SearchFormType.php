<?php

namespace App\Form;

use App\Entity\Outing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', ChoiceType::class, [
                'choices' => $options['campus_list'],
                'choice_value' => function($campus) {
                    return $campus ? $campus->getId() : '';
                },
                'choice_label' => function($campus) {
                    return $campus ? $campus->getName() : '';
                }
            ])
            ->add('type', ChoiceType::class, [
                'choices' => $options['types_list'],
                'choice_value' => function($type) {
                    return $type ? $type->getId() : '';
                },
                'choice_label' => function($type) {
                    return $type ? $type->getName() : '';
                }
            ])
            ->add('keyword', TextType::class)
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('isOrganiser',CheckboxType::class, [
                'label' => "Sorties que j'organise",
            ])
            ->add('participates', CheckboxType::class,[
                'label' => "Sorties auxquelles je suis inscrit(e)",
            ])
            ->add('doesntParticipate', CheckboxType::class, [
                'label' => "Sorties auxquelles je ne suis pas inscrit(e)",
            ])
            ->add('isFinished', CheckboxType::class, [
                'label' => "Sorties passées"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['campus_list', 'types_list']);
    }
}
