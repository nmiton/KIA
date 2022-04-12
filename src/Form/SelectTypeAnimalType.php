<?php

namespace App\Form;

use App\Entity\AnimalType;
use App\Entity\Score;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;

class SelectTypeAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('animalType', EntityType::class , [
            'attr' => ['autocomplete' => 'text','class' => 'form-control'],
            'class' => AnimalType::class,
            'label' => "Type d'animal :",
            'mapped' => false,
            'placeholder' => "Choisir un type d'animal",
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                ->orderBy('p.name', 'ASC');
            },
            'choice_label' => 'name',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Score::class,
        ]);
    }
}