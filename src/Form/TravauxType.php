<?php

namespace App\Form;

use App\Entity\Travaux;
use App\Entity\TypeTravaux;
use App\Entity\Unite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('prixUnitaire')
            ->add('code')
            // ->add('typeTravaux', EntityType::class, [
            //     'class' => TypeTravaux::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('unite', EntityType::class, [
            //     'class' => Unite::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travaux::class,
        ]);
    }
}
