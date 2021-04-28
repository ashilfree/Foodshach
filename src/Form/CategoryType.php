<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Repository\SubCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', EntityType::class, [
            'placeholder' => '-- Choose a category --',
            'class' => Category::class,
            'mapped' => false,
        ]);
//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//            function(FormEvent $event){
//                $form = $event->getForm();
//
//                $subCategories =  array();
//                $form->add('subCategory',   EntityType::class, array(
//                    'class'     =>  SubCategory::class,
//                    'placeholder'   => '-- Choose a Category first --',
//                    'choices'       => $subCategories
//                ));
//            }
//        );
//        $builder->get('category')->addEventListener(
//            FormEvents::POST_SUBMIT,
//            function(FormEvent $event){
//                $form = $event->getForm()->getParent();
//                $category = $event->getData();
//
//                // since we've added the listener to the child, we'll have to pass on
//                // the parent to the callback functions!
//
//                // Here we user a query_builder because the entity Account is not directly linked with Province
//                // otherwise we could have used a command like :
//                // $cites = null === $province ? array() : $province->getAvailableCities();
//                // and add 'choices' => $cities,
//                $form->add('subCategory',   EntityType::class, array(
//                    'class'     =>  SubCategory::class,
//                    'placeholder'   => '-- Choose a Category first --',
//                    'query_builder' => function (SubCategoryRepository $er) use ($category){
//                        return $er->createQueryBuilder('sc')
//                            ->join('sc.category', 'category')
//                            ->andWhere('category.id = :Category_id')
//                            ->setParameter('Category_id', $category);
//                    },
//                ));
//            }
//        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
