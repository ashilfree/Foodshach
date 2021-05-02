<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\CatalogType;
use App\Form\ImageFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/index', 'admin/product/index.html.twig')
            ->overrideTemplate('crud/new', 'admin/product/new.html.twig')
            ->overrideTemplate('crud/edit', 'admin/product/edit.html.twig')
//            ->setFormThemes(['@EasyAdmin/crud/form_theme.html.twig','admin/product/form.html.twig'])
            ->setFormThemes(['@EasyAdmin/crud/form_theme.html.twig','admin/product/form_theme.html.twig'])
            ->setPaginatorPageSize(1000)
//            ->overrideTemplates([
//                'crud/field/collection' => 'admin/product/collection.html.twig'
//            ])
            ;
    }




    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('nameAr'),
            SlugField::new('slug')->setTargetFieldName('name'),
            MoneyField::new('price')->setCurrency('KWD'),
            MoneyField::new('discountPrice', 'Discount')->setCurrency('KWD'),
            IntegerField::new('quantity'),
            TextareaField::new('description')->onlyOnForms(),
            TextareaField::new('descriptionAr')->onlyOnForms(),
            AssociationField::new('category'),
            AssociationField::new('subCategory'),
            AssociationField::new('hotDegree')->onlyOnForms(),
            CollectionField::new('images')
                ->setEntryType(ImageFileType::class)->onlyOnForms(),
            CollectionField::new('catalogs')
                ->setEntryType(CatalogType::class)
                ->onlyOnForms(),
            TextEditorField::new('longDescription')->onlyOnForms(),
            TextEditorField::new('longDescriptionAr')->onlyOnForms(),
        ];
    }

}
