<?php

namespace App\Form;

use App\Entity\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Gender;
use Symfony\Component\Form\Extension\Core\Type\EnumType;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('birthDate', DateType::class)
            ->add('firstName')
            ->add('lastName')
            ->add('gender', EnumType::class, ['class' => Gender::class])
            ->add('hire_date', DateType::class, [
                //affichage comme champ de texte
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                //si les 2 mdp ne correspondent pas, message d erreur a afficher
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                //remplissage oblig
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('photo')
            ->add('email')
            ->add('isVerified');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
