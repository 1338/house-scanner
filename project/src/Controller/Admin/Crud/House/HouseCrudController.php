<?php

namespace App\Controller\Admin\Crud\House;

use App\Entity\House\House;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HouseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return House::class;
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
