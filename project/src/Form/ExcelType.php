<?php

namespace App\Form;

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExcelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'label'=>"Choisir la catégorie des éléments que vous allez créer",
                'class' => Category::class,
                "placeholder" => "Choisissez une catégorie",
                // sort categories by alphabetical order
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('category')
                        ->select('category')
                        ->orderBy('category.name', 'ASC');
                },
                'choice_label' => function (Category $category) {
                    return $category->getName();
                }
                
            ])
            ->add('file', FileType::class, [
                'label' => 'Excel File',
            ])
            ->add('send', SubmitType::class, [
                'label'=>'Envoyer'
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
