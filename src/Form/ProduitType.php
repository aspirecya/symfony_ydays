<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Salle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_arrivee', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('date_depart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('prix', MoneyType::class)
            ->add('etat', ChoiceType::class, [
                'choices'  => [
                    'Reservée' => "Reservée",
                    'Libre' => "Libre",
                ],
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => 'titre'
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
