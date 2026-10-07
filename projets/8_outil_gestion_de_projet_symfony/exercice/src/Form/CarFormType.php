<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class CarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'required' => true,
                'constraints' => [
                    new Length(min: 3, max: 255)
                ]
            ])
            ->add('description', null, [
                'required' => true,
            ])
            ->add('monthlyPrice', Number, [
                'required' => true,

            ])
            ->add('dailyPrice', null, [
                'required' => true,
            ])
            ->add('places', ChoiceType::class, [
                'required' => true,
                'choices' => [1,2,3,4,5,6,7,8,9,10],
                'constraints' => [
                    new Length(min: 1, max: 10)
                ]
            ])
            ->add('motor', null, [
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
