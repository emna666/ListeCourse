<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Delegation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocaliteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('delegation')
            ->add('delegation', EntityType::class, array(
                "class"         => Delegation::class,
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('d')
                        ->join("d.governorat","g")
                        ->orderBy('g.name', 'ASC');
                },
                'group_by' => function ($val, $key, $index) {
                    return $val->getGovernorat()->getName();
                },
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'back\GeneralBundle\Entity\Localite'
        ));
    }
}
