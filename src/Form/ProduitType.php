<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_arrivee')
            ->add('date_depart')
            ->add('prix')
            ->add('etat', ChoiceType::class, [
                'choices'  => [
                    'Reservée' => true,
                    'Libre' => false
                ],
            ])
            ->add('id', EntityType::class, [
                'class'        => 'App:Salle',
                'choice_label' => 'titre',
                'label'        => 'A quelle salle appartiens ce produit?',
                'expanded'     => false,
                'multiple'     => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
