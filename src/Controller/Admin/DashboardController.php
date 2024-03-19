<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

use App\Entity\EloquenceContestParticipant;
use App\Entity\Award;
use App\Entity\EloquenceSubject;
use App\Entity\Formation;
use App\Entity\EloquenceContest;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(EloquenceContestParticipantCrudController::class)->generateUrl();

        return $this->redirect($url);

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
        ->setTranslationDomain('admin')
            ->setTitle('Festival Les Talents de l\'IUT - Administration')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard');
        // yield MenuItem::section();
        yield MenuItem::subMenu('Concours d\'éloquence', '')->setSubItems([
            MenuItem::linkToCrud('Gestion des concours', '', EloquenceContest::class),
            MenuItem::linkToCrud('Participants', '', EloquenceContestParticipant::class),
        ]);
        // yield MenuItem::linkToCrud('Participants aux concours d\'éloquence', '', EloquenceContestParticipant::class);
        // yield MenuItem::linkToCrud('Concours d\'éloquence', '', EloquenceContest::class);
        yield MenuItem::linkToCrud('Sujets concours d\'éloquence', '', Award::class);
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Prix', '', Award::class);
        yield MenuItem::linkToCrud('Liste formations', '', Formation::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
