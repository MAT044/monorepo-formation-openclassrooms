<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null, ['label' => 'Prénom'])
            ->add('lastname', null, ['label' => 'Nom'])
            ->add('email', null, ['label' => 'Email'])
            ->add('status',  null, ['label' => 'Status'])
            ->add('entryAt', null, [
                'label' => 'Date d\'entrée',
                'widget' => 'single_text'
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
