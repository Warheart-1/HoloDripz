<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\SubCategory;
use App\Entity\Cart;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;



class DashboardController extends AbstractDashboardController 
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
       

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
            ->setTitle('test');

    }

   
    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            
            MenuItem::section('Products'),
            MenuItem::linkToCrud('Products', 'fas fa-list', Product::class)
            ->setBadge("Update", 'success'),
            MenuItem::section('Categories'),
            MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class)
            ->setBadge("Update", 'success'),
            MenuItem::linkToCrud('SubCategories', 'fas fa-list', SubCategory::class)
            ->setBadge("Update", 'success'),
            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fas fa-list', User::class)
            ->setBadge("Update", 'success'),
            MenuItem::linkToCrud('Cart', 'fas fa-list', Cart::class)
            ->setBadge("Update", 'success'),
            
        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
