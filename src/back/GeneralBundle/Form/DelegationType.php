<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Governorat;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DelegationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('governorat')
            ->add('governorat', EntityType::class, array(
                "class"         => Governorat::class,
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'back\GeneralBundle\Entity\Delegation'
        ));
    }
}
