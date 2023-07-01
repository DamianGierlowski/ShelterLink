<?php

namespace App\Form\Admin;

use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genre',EntityType::class, [
                'mapped' => false,
                'class' => Genre::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('file', FileType::class, [
                'label' => 'File',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

}