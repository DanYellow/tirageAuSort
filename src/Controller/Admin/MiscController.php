<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

class MiscController extends DashboardController
{
    #[Route('/festi-admin/misc/', name: 'admin_misc')]
    public function index(): Response
    {
        return $this->render('misc/index.html.twig', [
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/festi-admin/misc/logo', name: 'admin_misc_update_logo')]
    public function update_logo(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];

        $form = $this->createFormBuilder($defaultData)
            ->add('task', FileType::class, [
                "attr" => ["class" => "form-control"],
                "label" => "Image",
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        if ($form->isSubmitted()) {
            dump("ffzzzz");
            exit;
        }

        return $this->render('misc/form-logo.html.twig', [
            'form' => $form,
        ]);
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }
}
