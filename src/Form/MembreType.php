<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints as Assert;
class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add("civilite", ChoiceType::class, [
            'label' => false,
            'choices'  => [
                'Monsieur' => "Monsieur",
                'Madame' => "Madame",
            ],
        ])
        ->add("nom", null, [
            'label' => false,
        ])
        ->add("prenom", null, [
            'label' => false,
        ])
        ->add("pseudo", null, [
            'label' => false,
        ])
        ->add('email', null, [
            'label' => false,
        ])
        ->add('plainPassword', PasswordType::class, [
            'required'   => false,
            'label' => false,
            'mapped' => false,
        ]);
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Membre::class,
    ]);
}
}
