<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Transaction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Amount', NumberType::class)
            ->add('account', EntityType::class, [
                'label'        => 'Account',
                'class'        => Account::class,
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => true,
            ])
            ->add('user', EntityType::class, [
                'label'        => 'User',
                'class'        => User::class,
                'choice_label' => 'email',
                'multiple'     => false,
                'required'     => true,
            ])
            ->add('category', EntityType::class, [
                'label'        => 'Category',
                'class'        => Category::class,
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
