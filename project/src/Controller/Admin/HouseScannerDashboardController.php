<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Crud\House\HouseCrudController;
use App\Entity\Address;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\House\House;
use App\Entity\House\Location;
use App\Entity\Municipality;
use App\Entity\Neighbourhood;
use App\Entity\Postcode;
use App\Entity\Road;
use App\Entity\State;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HouseScannerDashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(HouseCrudController::class)->generateUrl());


        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('House-Scanner')

        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('House'),
            MenuItem::linkToCrud('House', 'fa fa-home', House::class),
            MenuItem::linkToCrud('Location', 'fa fa-tags', Location::class),
            MenuItem::section('Location Data'),
            MenuItem::linkToCrud('Address', 'fa fa-home', Address::class),
            MenuItem::linkToCrud('Road', 'fa fa-home', Road::class),
            MenuItem::linkToCrud('Neighbourhood', 'fa fa-home', Neighbourhood::class),
            MenuItem::linkToCrud('Municipality', 'fa fa-home', Municipality::class),
            MenuItem::linkToCrud('City', 'fa fa-home', City::class),
            MenuItem::linkToCrud('State', 'fa fa-home', State::class),
            MenuItem::linkToCrud('Country', 'fa fa-home', Country::class),
            MenuItem::linkToCrud('Postcode', 'fa fa-home', Postcode::class),

        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
