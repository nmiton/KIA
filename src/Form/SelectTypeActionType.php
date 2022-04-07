<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SelectTypeAction extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('actionType', ChoiceType::class, [
            'label' => "Trier par catégorie :",
            'placeholder' => "Toutes les catégories",
            'attr' => ['class' => 'form-control'],
            'required'=>false,
            'choices'  => [
                'Pour la faim' => 'Nourrir',
                'Pour la soif' => 'Boire',
                'Pour la santé' => 'Soin',
                'Pour jouer' => 'Jouer',
                'Pour sortir' => 'Sortir',
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
