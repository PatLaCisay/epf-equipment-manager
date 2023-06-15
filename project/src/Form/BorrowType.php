<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Borrow;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BorrowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'data' => new \DateTimeImmutable(),
                'required' => true,
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'Date de début'
            ])
            ->add('endDate', DateType::class, [
                'data' => new \DateTimeImmutable(),
                'required' => true,
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('description', TextType::class, [
                'required' => true,
                'label' => 'Description'
            ])
            ->add('stakeholder', EntityType::class, [
                'label'=>"Email du responsable du materiel",
                'class' => User::class,
                'required' => true,
                "placeholder" => "Choisissez un utilisateur",
                // sort stakeholder by alphabetical order
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('user')
                        ->select('user')
                        ->orderBy('user.email', 'ASC');
                },
                'choice_label' => function (User $user) {
                    return $user->getEmail();
                }
            ])
            ->add('projectManager', EntityType::class, [
                'label'=>"Email du chef de projet",
                'class' => User::class,
                'required' => true,
                "placeholder" => "Choisissez un utilisateur",
                // sort stakeholder by alphabetical order
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('user')
                        ->select('user')
                        ->orderBy('user.email', 'ASC');
                },
                'choice_label' => function (User $user) {
                    return $user->getEmail();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrow::class,
        ]);
    }
}
