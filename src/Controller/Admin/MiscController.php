<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Image;

class MiscController extends DashboardController
{
    private const MIME_TYPES = [
        'image/png',
        'image/jpg',
        'image/jpeg',
    ];

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
            ->add('logo', FileType::class, [
                "attr" => [
                    "class" => "form-control",
                    "data-logo-input" => null,
                ],
                "label_attr" => ["class" => "form-control-label required"],
                "label" => "Logo",
                'required' => false,
                'help' => "Fichiers png, jp(e)g seulement",
                'constraints' => [
                    new Image([
                        'maxSize' => '2M', // 2048k
                        'mimeTypes' => MiscController::MIME_TYPES,
                        'mimeTypesMessage' => 'Merci de bien vouloir uploader une image correcte',
                    ])
                ],
            ])
            ->getForm()
        ;

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
