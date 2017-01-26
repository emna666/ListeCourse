<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Localite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('telephone2')
            ->add('adresse')
            ->add('cin')
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
            ->add('file')
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
