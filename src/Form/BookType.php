<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Enum\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add(
                'isbn', TextType::class, [
                'attr' => [
                    'maxlength' => 13,
                    'pattern' => '\d{13}',
                    'inputmode' => 'numeric',
                    'placeholder' => '13-digit ISBN',
                ],
            ],
            )
            ->add(
                'publicationDate', DateType::class, [
                'widget' => 'single_text',
            ],
            )
            ->add(
                'genre', EnumType::class, [
                'class' => Genre::class,
            ],
            )
            ->add('numberOfCopies', IntegerType::class)
            ->add(
                'author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
            ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Book::class,
            ],
        );
    }
}
