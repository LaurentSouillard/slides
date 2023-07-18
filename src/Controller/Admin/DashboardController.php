<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Categories;
use App\Controller\Admin\ImagesCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

//#[Route('/admin/dashboard')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {}

    #[Route('/admin/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
        ->setController(ImagesCrudController::class)
        ->generateUrl();

        return $this->redirect($url);
        
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
        
        //return $this->render('home/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        //yield MenuItem::linkToRoute('Accueil', 'fas fa-table-columns', 'app_home');
        //yield MenuItem::section('SlideShow');
        yield MenuItem::subMenu('SlideShow')->setSubItems([
            MenuItem::linkToRoute('SlideShow', 'fa-solid fa-circle-play', 'app_slide'),
            //MenuItem::linkToRoute('Vue générale', 'fa-solid fa-binoculars', 'app_home'),
            //MenuItem::linkToRoute('Position (SlideShow)', 'fa-solid fa-eye', 'app_position_slide'),
            //MenuItem::linkToCrud('Création de slides', 'fa-solid fa-plus', Slides::class),
        ]);
        //yield MenuItem::section('Thèmes');
        yield MenuItem::subMenu('Catégories')->setSubItems([
            MenuItem::linkToCrud('Liste des catégories', 'fas fa-list', Categories::class),
            //MenuItem::linkToCrud('Positions', 'fa-solid fa-crosshairs', Positions::class),
            MenuItem::linkToRoute('Catégories', 'fa-solid fa-layer-group', 'app_categories'),
        ]);
        //yield MenuItem::section('Images');
        yield MenuItem::subMenu('Images')->setSubItems([
            MenuItem::linkToCrud('Images', 'fas fa-images', Images::class),
            MenuItem::linkToRoute('Ajout des images', 'fa-solid fa-folder-plus', 'app_gallery_new'),
        ]);
        //yield MenuItem::section('Utilisateurs');
        yield MenuItem::subMenu('Utilisateurs')->setSubItems([
            MenuItem::linkToRoute('Créer un utilisateur', 'fa-solid fa-user', 'app_register'),
        ]); 
    }
}
