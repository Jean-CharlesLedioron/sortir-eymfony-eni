<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'Nom :'
            ])
            ->add('prenom',TextType::class,[
                'label'=>'Prenom :'
            ])
            ->add('pseudo',TextType::class,[
                'label'=>'Pseudo :'
            ])
            ->add('telephone',TextType::class,[
                'label'=>'Téléphone :',
                'required'=> false
            ])
            ->add('mail',TextType::class,[
                'label'=>'Email :'
            ])
            ->add('motPasse',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe :'],
                'second_options' => ['label' => 'Confirmer Mot de passe :']
            ])
            ->add('administrateur',TextType::class,[
                'label'=>'Utilisateur admin (1 oui, 0 non) :'
            ])
            ->add('actif',TextType::class,[
                'label'=>'Utilisateur actif (1 oui, 0 non) :'
            ])
            ->add('campus',EntityType::class,[
                'class'=> Campus::class,
                'choice_label'=> 'nom',
                'label'=> 'Campus :'
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
