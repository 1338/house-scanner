<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Neighbourhood;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NeighbourhoodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Neighbourhood::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
