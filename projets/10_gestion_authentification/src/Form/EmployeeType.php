<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null, ['label' => 'Prénom', 'required' => false])
            ->add('lastname', null, ['label' => 'Nom', 'required' => false])
            ->add('email', null, ['label' => 'Email', 'required' => false])
            ->add('status',  null, ['label' => 'Status', 'required' => false])
            ->add('entryAt', DateType::class, [
                'label' => 'Date d\'entrée',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
