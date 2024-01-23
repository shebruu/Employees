<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Employee;
use App\Entity\Intern;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname')
            ->add('startDate')
            ->add('endDate')
            ->add('deptNo', EntityType::class, [
                'class' => Departement::class,
'choice_label' => 'id',
            ])
            ->add('empNo', EntityType::class, [
                'class' => Employee::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intern::class,
        ]);
    }
}
