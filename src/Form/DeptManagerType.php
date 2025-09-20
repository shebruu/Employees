<?php

namespace App\Form;


use App\Entity\Departement;
use App\Entity\DeptManager;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeptManagerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => function ($departement) {
                    return $departement->getDeptName();
                },
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => function ($employee) {
                    return $employee->getFirstName() . ' ' . $employee->getLastName();
                },
            ])
            ->add('fromDate')
            ->add('toDate');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DeptManager::class,
        ]);
    }
}
