<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Municipality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MunicipalityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Municipality::class;
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
