<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\PaymentMethods;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', hiddenType::class)
            ->add('shippingFirstName', TextType::class, [
                'label'=>false
            ])
            ->add('shippingLastName', TextType::class, [
                'label'=>false
            ])
            ->add('shippingCompanyName', TextType::class, [
                'label'=>false,
                'required' => false
            ])
            ->add('shippingAddress', TextType::class, [
                'label'=>false,
                'attr' => [
                    'id' => 'address'
                ]
            ])
            ->add('shippingCity', TextType::class, [
                'label'=>false
            ])
            ->add('shippingProvince', TextType::class, [
                'label'=>false
            ])
            ->add('shippingCountry', ChoiceType::class, [
                'choices'  => [
                    'Kuwait' => 0,
                ]
            ])
            ->add('shippingPostalCode', null, [
                'help' => 'The ZIP/Postal code for your credit card\'s billing address.',
                'label'=>false
            ])
            ->add('shippingLat', HiddenType::class)
            ->add('shippingLng', HiddenType::class)
            ->add('shippingEmail', EmailType::class, [
                'label'=>false
            ])
            ->add('shippingPhone', TelType::class, [
                'label'=>false,
            ])
            ->add('notes', TextareaType::class, [
                'label'=>false,
                'required' => false
            ])
            ->add('paymentMethod', EntityType::class, [
                'class'  => PaymentMethods::class,
                'placeholder' => 'Choose an option *',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
