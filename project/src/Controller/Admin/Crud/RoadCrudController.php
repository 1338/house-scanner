<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Road;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RoadCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Road::class;
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
