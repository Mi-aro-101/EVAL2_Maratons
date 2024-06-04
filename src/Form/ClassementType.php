<?php

namespace App\Form;

use App\Entity\Classement;
use App\Entity\Coureur;
use App\Entity\EtapeCourse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rang')
            ->add('point')
            ->add('coureur', EntityType::class, [
                'class' => Coureur::class,
                'choice_label' => 'id',
            ])
            ->add('etapeCourse', EntityType::class, [
                'class' => EtapeCourse::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classement::class,
        ]);
    }
}
