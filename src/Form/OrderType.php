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
            ->add('shippingFullName', TextType::class, [
                'label'=>false
            ])
            ->add('shippingStreetNumber', TextType::class, [
                'label'=>false
            ])
            ->add('shippingHouseNumber', TextType::class, [
                'label'=>false,
                'required' => false
            ])
            ->add('shippingApartment', TextType::class, [
                'label'=>false,
                'required' => false
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
                'invalid_message' => 'Invalid Phone Number'
            ])
            ->add('notes', TextareaType::class, [
                'label'=>false,
                'required' => false
            ])
            ->add('paymentMethod', EntityType::class, [
                'class'  => PaymentMethods::class,
                'placeholder' => 'Choose an option *',
                'required' => false
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
