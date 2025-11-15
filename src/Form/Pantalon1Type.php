<?php

namespace App\Form;

use App\Entity\Pantalon;
use App\Enum\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class Pantalon1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('marque')
            ->add('taille')
            ->add('description')
            ->add('stock')
            ->add('status', ChoiceType::class, [
                'choices' => Status::cases(),
                'choice_label' => fn(Status $status) => $status->name,
                'choice_value' => fn(?Status $status) => $status?->value,
            ])
            ->add('images', FileType::class, [
                'label' => 'Image',
                'mapped' => false, 
                'required' => false,
                'multiple' => true
            ]);
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pantalon::class,
        ]);
    }
}
