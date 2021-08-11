<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\SearchFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class,[
                'label'=>"Campus",
                'required'=>false,
                'class'=>Campus::class,
                'choice_label'=>'nom'
            ])
            ->add('search', TextType::class,[
                'label'=> 'Le nom de la sortie contient',
                'required'=>false
            ])
            ->add('startDate', DateType::class,[
                'label'=>'Entre',
                'html5' => true,
                'widget' => 'single_text',
                'required'=>false
            ])
            ->add('EndDate',DateType::class,[
                'label'=>'Et',
                'html5' => true,
                'widget' => 'single_text',
                'required'=>false

            ])
            ->add('Organisator',CheckboxType::class,[
                'label'=> "Sorties dont je suis l'organisateur.rice",
                'required'=>false
            ])
            ->add('signIn',CheckboxType::class,[
                'label'=> "Sorties auxquelles je suis inscrit.e",
                'required'=>false
            ])
            ->add('notSignIn',CheckboxType::class,[
                'label'=> "Sorties auxquelles je ne suis pas inscrit.e",
                'required'=>false
            ])
            ->add('passed',CheckboxType::class,[
                'label'=> "Sorties Passées",
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchFilter::class,
           // 'method' => 'GET',
        ]);
    }


}
