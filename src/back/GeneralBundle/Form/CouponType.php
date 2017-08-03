<?php

namespace back\GeneralBundle\Form;

use back\GeneralBundle\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CouponType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelle')
            ->add('description',TextareaType::class)
            ->add('promo')
            ->add('dateDebut',DateType::class,array(
                "widget"=>"single_text"
            ))
            ->add('code')
            ->add('file')
            ->add('produit', EntityType::class, array(
                "class"         => Produit::class,
                'query_builder' => function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.libelle', 'ASC');
                },
            ))
        ;
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'back\GeneralBundle\Entity\Coupon'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'back_generalbundle_coupon';
    }


}
