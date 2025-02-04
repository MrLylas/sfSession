<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('placesNb', null, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
            ])
            // ->add('trainees', EntityType::class, [
            //     'class' => Trainee::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
