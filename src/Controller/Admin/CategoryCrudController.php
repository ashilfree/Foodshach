<?php

namespace App\Controller\Admin;

use App\Admin\Field\TagField;
use App\Entity\Category;
use App\Form\SizeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
            ->setFormThemes(['@EasyAdmin/crud/form_theme.html.twig','admin/about/form.html.twig'])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('nameAr', 'الاسم'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('imageFile', 'Home image')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('fileName', 'Home image')->setCustomOption('basePath', 'media/images/category/')->onlyOnIndex(),
            ImageField::new('imageFile2', 'Intro image')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('fileName2', 'Intro image')->setCustomOption('basePath', 'media/images/category/')->onlyOnIndex(),
        ];
    }

}
