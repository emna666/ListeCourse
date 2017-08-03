<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Marque;
use back\GeneralBundle\Entity\Supermarche;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('numSerie')
            ->add('description'
            )->add('prix')
            ->add('file')
            ->add('categories')
            ->add('marque', EntityType::class, array(
                "class"         => Marque::class,
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.libelle', 'ASC');
                },
            ))
            ->add('supermarche')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'back\GeneralBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'back_generalbundle_produit';
    }


}
