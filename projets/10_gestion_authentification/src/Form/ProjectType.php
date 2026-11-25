<?php

namespace App\Form;

use App\Dto\WriteProjectDto;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => 'Titre du projet'])
            ->add('members', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'firstname',
                'multiple' => true,
                'label' => 'Inviter des membres',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WriteProjectDto::class,
        ]);
    }
}
