<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Controller\Admin\EloquenceContestParticipantCrudController;

use App\Entity\EloquenceContestParticipant;
use App\Entity\Award;
use App\Entity\EloquenceSubject;
use App\Entity\Formation;
use App\Entity\EloquenceContest;

class DashboardController extends AbstractDashboardController
{
    #[Route('/festi-admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(EloquenceContestCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTranslationDomain('admin')
            ->setTitle('<img src="images/logo-talents-iut.png" alt="" width="60" /><br/><span>Festival Les Talents de l\'IUT - Administration</span>')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Gestion des concours', null, EloquenceContest::class);
        yield MenuItem::subMenu('Concours d\'éloquence', null)->setSubItems([
            MenuItem::linkToCrud('Gestion des concours', null, EloquenceContest::class),
            MenuItem::linkToCrud('Participants', null, EloquenceContestParticipant::class),
            MenuItem::linkToCrud('Sujets', null, EloquenceSubject::class),
        ]);
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Formations', null, Formation::class);
        yield MenuItem::section();
        yield MenuItem::linkToRoute('Accéder au site', null, "index");
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserAvatar(false);
    }
}
