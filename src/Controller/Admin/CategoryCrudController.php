<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\SubCategoryType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/new', 'admin/category/new.html.twig')
            ->overrideTemplate('crud/edit', 'admin/category/edit.html.twig')
            ->setFormThemes(['@EasyAdmin/crud/form_theme.html.twig','admin/category/form.html.twig'])
            ->setPaginatorPageSize(100)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('nameAr', 'الاسم'),
            SlugField::new('slug')->setTargetFieldName('name'),
            CollectionField::new('subCategories')
                ->setEntryType(SubCategoryType::class)
                ->onlyOnForms(),
            ImageField::new('imageFile', 'Home image')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('fileName', 'Home image')->setCustomOption('basePath', 'media/images/category/')->onlyOnIndex(),
            ImageField::new('imageFile2', 'Intro image')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('fileName2', 'Intro image')->setCustomOption('basePath', 'media/images/category/')->onlyOnIndex(),
        ];
    }

}
