<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecetteSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', EntityType::class, array(
                "class"         => Produit::class,
                "required"      => false,
                "placeholder"   => 'Tous',
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.libelle', 'ASC');
                },
            ));
    }


}
