<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\AnimalType as EntityAnimalType;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                'attr' => ['autocomplete' => 'text','class' => 'form-control','placeholder' => "roxy"],
                'label' => "Nom :",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom',
                    ]),
                ],
            ])
            // ->add('isAlive')
            // ->add('lastActive')
            // ->add('createdAt')
            ->add('animalType', EntityType::class , [
                'attr' => ['autocomplete' => 'text','class' => 'form-control'],
                'class' => EntityAnimalType::class,
                'label' => "Type d'animal :",
                'placeholder' => "Choisir un type d'animal",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                    ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('user', EntityType::class , [
                'attr' => ['autocomplete' => 'text','class' => 'form-control'],
                'class' => User::class,
                'label' => "Propriétaire :",
                'placeholder' => "Choisir un propriétaire :",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                    ->orderBy('p.pseudo', 'ASC');
                },
                'choice_label' => 'pseudo',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
