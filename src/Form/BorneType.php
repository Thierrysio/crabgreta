<?php

namespace App\Form;

use App\Entity\Borne;
use App\Entity\Station;
use App\Entity\TypeBorne;
use App\Entity\Visite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDerniereRevision', null, [
                'widget' => 'single_text',
            ])
            ->add('indiceCompteurUnites')

            ->add('leTypeBorne', EntityType::class, [
                'class' => TypeBorne::class,
                'choice_label' => 'id',
            ])
            ->add('laStation', EntityType::class, [
                'class' => Station::class,
                'choice_label' => 'libelle_emplacement',
            ])
            // Ajout du bouton de soumission au formulaire
            ->add('save', SubmitType::class, [
                'label' => 'Créer  borne', // Vous pouvez personnaliser le label du bouton ici
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borne::class,
        ]);
    }
}
