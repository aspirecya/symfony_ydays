<?php

namespace App\Form;

use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('file', FileType::class)
            ->add('pays')
            ->add('ville')
            ->add('adresse')
            ->add('cp')
            ->add('capacite')
            ->add('categorie', ChoiceType::class, [
                'choices'  => [
                    "Réunion" => "Réunion",
                    "Bureau" =>"Bureau",
                    "Formation" => "Formation",
                ],
            ])
            ->add('valider', SubmitType::class);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}
