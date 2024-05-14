<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\TypeFinition;
use App\Entity\TypeMaison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDevis', null, [
                'widget' => 'single_text',
            ])
            ->add('dateDebutTravaux')
            ->add('typeFinition', EntityType::class, [
                'class' => TypeFinition::class,
                'choice_label' => 'designation',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
