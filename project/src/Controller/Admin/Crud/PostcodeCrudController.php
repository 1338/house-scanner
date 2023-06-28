<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Postcode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostcodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Postcode::class;
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
