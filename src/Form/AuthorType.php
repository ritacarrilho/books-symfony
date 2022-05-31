<?php
// equivelent to Model
namespace App\Form;

use App\Entity\Author;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { // form creation/personalization
        $builder
            ->add('firstName', null, [
                'label' => 'Author\'s first name',
                'attr' => ['placeholder' => 'First name'],
                'required' => true
            ])
            ->add('lastName', null, [
                'label' => 'Author\'s last name',
                'attr' => ['placeholder' => 'Last name'],
                'required' => true
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Author\'s birth date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                // 'data' => new \DateTime(),
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Author::class]);
    }
}