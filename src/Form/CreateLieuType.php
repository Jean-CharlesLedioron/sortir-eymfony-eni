<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateLieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du lieu',
            ])
            ->add('rue', TextType::class, [
                'label' => 'Nom de la rue',
            ])
            ->add('latitude', TextType::class, [
                'label' => 'latitude',
            ])
            ->add('longitude', TextType::class, [
                'label' => 'longitude',
            ])
            ->add('ville', EntityType::class, [
                'label' => 'Nom du lieu',
                'class' => Ville::class,
                'choice_label' => 'nom'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
