<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CharacterHtmlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('kind', TextType::class)
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('caste', TextType::class, array (
                'required' => false,
                'help' => 'Caste du character'
            ))
            ->add('knowledge', TextType::class, array (
                'required' => false
            ))
            ->add('intelligence', IntegerType::class, array (
                'required' => false,
                'help' => 'Niveau d\'intelligence',
                'attr' => array (
                    'min' => 1,
                    'max' => 255
                )
            ))
            ->add('life', IntegerType::class, array (
                'required' => false,
                'label' => 'Vie du character',
                'attr' => array (
                    'min' => 1,
                    'max' => 255,
                    'placeholder' => 'niveau de vie du character'
                )
            ))
            ->add('image', TextType::class, array (
                'required' => false
            ))
            ->add('player', TextType::class, array (
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
