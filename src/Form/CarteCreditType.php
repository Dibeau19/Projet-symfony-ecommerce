<?php

namespace App\Form;

use App\Entity\CarteCredit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CarteCreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'label' => 'Numéro de carte',
                'attr' => ['placeholder' => '0000 0000 0000 0000'],
                'constraints' => [
                    new NotBlank(),
                    // Validation très souple pour tests
                ]
            ])
            ->add('dateExpiration', DateType::class, [
                'label' => "Date d'expiration",
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('cvv', TextType::class, [
                'label' => 'CVV',
                'attr' => ['placeholder' => '123'],
                'constraints' => [
                    new NotBlank(),
                    // Validation très souple pour tests
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteCredit::class,
            'csrf_protection' => false,
        ]);
    }
}
