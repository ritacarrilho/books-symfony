<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Genre;
use App\Repository\AuthorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('synopsis')
            ->add('dateParution')
            ->add('dateEdition')
            ->add('nbrPage')
            ->add('editor')
            ->add('isbn')
            ->add('ean')
            ->add('author', EntityType::class, [
                'label' => 'Author name',
                'query_builder' => function(AuthorRepository $authorRepo) { 
                    return $authorRepo->orderLabel();
                },
                'class' => Author::class,
                'placeholder' => 'Choose an author',
                'choice_label' => 'fullName',
                'expanded' => false,
                'multiple' => true,
                'mapped' => false
            ])
            ->add('category', EntityType::class, [
                'label' => 'Publishing type',
                'class' => Category::class,
                'placeholder' => 'Choose a type',
                'choice_label' => 'label',
                'expanded' => false,
                'multiple' => true,
                'mapped' => false
            ])
            ->add('genre', EntityType::class, [
                'label' => 'Publishing type',
                'class' => Genre::class,
                'placeholder' => 'Choose a Genre',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, ['label' => 'Save' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
