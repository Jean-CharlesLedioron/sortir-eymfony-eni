<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,[
                'label' => 'Pseudo :',
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom :'
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom :'
            ])
            ->add('telephone', TextType::class,[
                'label' => 'Téléphone :',
                'required' => false
            ])
            ->add('mail', TextType::class,[
                'label' => 'Mail :'
            ])
            ->add('motPasse',RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Mot de passe :'],
                    'second_options' => ['label' => 'Confirmer Mot de passe :']
            ])
            ->add('campus',EntityType::class,[
                'class' => Campus::class,
                'choice_label' => 'nom',
                'label'=> 'Campus :'
            ])

            //TODO ajouter le systeme pour la photo
            ->add('photo',FileType::class,[
                'label' => 'Ajouter une photo de profil :',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
