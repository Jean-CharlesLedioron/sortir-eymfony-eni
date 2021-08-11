<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : '
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée : '
            ])
            ->add('dateLimiteInscription', DateTimeType::class, [
                'label' => 'Date limite d\'inscription : ',
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre de places : '
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Description et infos : ',
                'attr' => [
                    'rows' => "3",
                ]
            ])
            ->add('campusSiteOrganisateur', EntityType::class, [
                'label' => 'Campus : ',
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
            ->add('lieu', EntityType::class, [
                'label' => 'Lieu : ',
                'class' => Lieu::class,
                'choice_label' => 'nom',
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'required' => true,
                'mapped' => false,
                'label' => 'Ville :',
                'placeholder' => 'Choisissez une ville',
                'choice_label' => 'nom',
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'required' => true,
                'label' => 'Lieu :',
                'placeholder' => 'Choisissez un lieu',
                'choice_label' => 'nom',
            ])
            ->add('rue', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'rue',
                'mapped' => false,
                'attr' => ['readonly' => true,]
            ])
            ->add('codePostal', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'codePostal',
                'mapped' => false,
                'attr' => ['readonly' => true,
                ]
            ])
            ->add('latitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'latitude',
                'mapped' => false,
                'attr' => ['readonly' => true,
                ]
            ])
            ->add('longitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'longitude',
                'mapped' => false,
                'attr' => ['readonly' => true,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}

