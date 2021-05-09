<?php

namespace App\Controller\Admin;

use App\Entity\About;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
//            ->overrideTemplate('crud/index', 'admin/slide/index.html.twig')
            ->overrideTemplate('crud/new', 'admin/about/new.html.twig')
            ->overrideTemplate('crud/edit', 'admin/about/edit.html.twig')
//            ->overrideTemplate('crud/field/image', 'admin/slide/field/image.html.twig')
            ->setFormThemes(['@EasyAdmin/crud/form_theme.html.twig','admin/about/form.html.twig'])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextField::new('titleAr', 'العنوان')->addCssClass('text-right'),
            TextareaField::new('description1', 'First description')->onlyOnForms(),
            TextareaField::new('descriptionAr1', 'الوصف الاول')->onlyOnForms()->addCssClass('text-right'),
            TextareaField::new('description2', 'Second description')->onlyOnForms(),
            TextareaField::new('descriptionAr2', 'الوصف الثاني')->onlyOnForms()->addCssClass('text-right'),
            TextareaField::new('description3', 'Third description')->onlyOnForms(),
            TextareaField::new('descriptionAr3', 'الوصف الثالث')->onlyOnForms()->addCssClass('text-right'),
            TextareaField::new('description4', 'Fourth description')->onlyOnForms(),
            TextareaField::new('descriptionAr4', 'الوصف الرابع')->onlyOnForms()->addCssClass('text-right'),
            UrlField::new('btnUrl')->onlyOnForms(),
            ImageField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('fileName')->setCustomOption('basePath', 'media/images/about/')->onlyOnIndex(),
        ];
    }

}
