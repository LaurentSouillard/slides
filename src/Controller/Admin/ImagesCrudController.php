<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Images::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('nom', 'Image')
            ->setBasePath('img/')
            ->setUploadDir('public/img/'),
            //->setUploadedFileNamePattern('[randomhash].[extension]'),
            /*->setFormTypeOption('attr', ['required' => 'required'])
            ->setRequired(false),*/
            /*->setFormTypeOptions(['multiple' => true]),*/
            TextField::new('descriptif'),
            AssociationField::new('categorie', 'Catégorie'),/*
            ->setFormTypeOption('attr', ['required' => 'required'])
            ->setRequired(true),*/
            IntegerField::new('position')
            ->setFormTypeOption('attr', ['min' => 1]),
            BooleanField::new('inSlide', 'IN Slide'),
            //AssociationField::new('position')
            //AssociationField::new('slide', 'Position')
        ];
    }

    /*public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(['themes']);
    }*/

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(EntityFilter::new('categorie'))
        ->add(BooleanFilter::new('in_slide', 'IN Slide'))
        ;
    }
    
}
