<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Genre;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chip')
            ->add('name')
            ->add('birthday_date')
            ->add('colour')
            ->add('gender',ChoiceType::class, [
                'choices'  => [
                    'M' => 'M',
                    'F' => 'F',
                ],
            ])
            ->add('genre',EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('room',EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'code',
                'required' => false,
            ])
            ->add('file', FileType::class, [
                'label' => 'File',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
