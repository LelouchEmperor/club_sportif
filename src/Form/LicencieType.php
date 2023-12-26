<?php

namespace App\Form;

use App\Entity\Licencie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LicencieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroLicence')
            ->add('nom')
            ->add('prenom')
            ->add('contact')
            ->add('categorie')
            ->add('educateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Licencie::class,
        ]);
    }
}
