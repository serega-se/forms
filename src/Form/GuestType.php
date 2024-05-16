<?php

namespace App\Form;

use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'firstname_form_label'])
            ->add('lastname', TextType::class, ['label' => 'lastname_form_label'])
            ->add('description', TextType::class, ['label' => 'description_form_label'])
            ->add('submit', SubmitType::class, ['label' => 'save_form_label'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
            'translation_domain' => 'forms'
        ]);
    }
}
