<?php

namespace back\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SupermarcheType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('latitude')
            ->add('longitude')
            ->add('file')
            ->add('email')
            ->add('telephone')
            ->add('adresse');
    }
}
