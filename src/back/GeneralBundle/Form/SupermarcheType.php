<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Localite;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupermarcheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('latitude')
            ->add('longitude')
            ->add('email')
            ->add('telephone')
            ->add('adresse')
            ->add('file')
            ->add('localite', EntityType::class, array(
                "class"         => Localite::class,
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('d')
                        ->join("d.delegation","g")
                        ->orderBy('g.name', 'ASC');
                },
                'group_by' => function ($val, $key, $index) {
                    return $val->getDelegation()->getGovernorat()->getName();
                },
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'back\GeneralBundle\Entity\Supermarche'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'back_generalbundle_supermarche';
    }


}
