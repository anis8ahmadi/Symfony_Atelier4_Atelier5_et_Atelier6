<?php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Serie', TextType::class)
            ->add('Date_Mise_En_Marche', DateTimeType::class)
            ->add('Modele', TextType::class, [
                'class' => Modele::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Selectionner le modele'
            ])
            ->add('Prix_jour', NumberType::class)
        ;
    }

    public function getName()
    {
        return 'voiture';
    }


}
