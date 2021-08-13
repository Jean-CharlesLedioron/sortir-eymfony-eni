<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditSortieType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
            ]);


        $builder->addEventListener(FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                $ville = $this->em->getRepository(Ville::class)->find($data['ville']);
                $this->addElements($form, $ville);

            });
        $builder->addEventListener(FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                $ville = $data->getLieu() ? $data->getLieu()->getVille() : null;
                $this->addElements($form, $ville);

            });
    }

    protected function addElements(FormInterface $form, Ville $ville = null)
    {
        $form->add('ville', EntityType::class, [
            'class' => Ville::class,
            'required' => true,
            'mapped' => false,
            'label' => 'Ville :',
            'placeholder' => 'Choisissez une ville',
            'choice_label' => 'nom',
        ]);

        $form->add('codePostal', TextType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,],
        ]);
        $form->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'required' => true,
            'label' => 'Lieu :',
            'placeholder' => 'Choisissez un lieu',
            'choice_label' => 'nom',
        ]);
        $form->add('rue', TextType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,]
        ]);
        $form->add('latitude', TextType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,]
        ]);
        $form->add('longitude', TextType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
