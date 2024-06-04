<?php

namespace App\Form;

use App\Entity\EtapeCourse;
use App\Entity\PointRang;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointRangType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('point')
            ->add('rang')
            ->add('etapeCourse', EntityType::class, [
                'class' => EtapeCourse::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PointRang::class,
        ]);
    }
}
