<?php

// src/Form/RechercheLicencieType.php

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RechercheLicencieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', TextType::class, ['required' => false])
            // Ajoutez d'autres champs au besoin
        ;
    }
}
