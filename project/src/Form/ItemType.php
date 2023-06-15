<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('stock', NumberType::class,[
                'label' => "Quantité"
            ])
            ->add('price', NumberType::class,[
                'label'=>'Prix unitaire'
            ])          
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
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
