<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Group;
use App\Entity\Borrow;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, ['data' => new \DateTime(),'required' => true])
            ->add('endDate',DateType::class, ['required' => true])
            ->add('description',TextType::class,['required' => true])
            ->add('quantity',NumberType::class,['required' => true])
            ->add('stakeholder', EntityType::class, [
                'class' => User::class,'required' => true,
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
            ->add('room', EntityType::class, [
                'required' => true,
                'class' => Room::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('room')
                        ->select('room')
                        ->orderBy('room.name', 'ASC');
                },
                'choice_label' => function (Room $room) {
                    return $room->getName();
                }
            ])
            ->add('items', EntityType::class, [
                'required' => true,
                'class' => Item::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('items')
                        ->select('items')
                        ->orderBy('items.name', 'ASC');
                },
                'choice_label' => function (Item $items) {
                    return $items->getName();
                },
                'mapped' => false
            ])
            ->add('team', EntityType::class, [
                'required' => true,
                'class' => Group::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('g')
                        ->select('g')
                        ->orderBy('g.name', 'ASC');
                },
                'choice_label' => function (Group $group) {
                    return $group->getName();
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
