<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Image;

class MiscController extends DashboardController
{
    private const MIME_TYPES = [
        'image/png',
    ];

    #[Route('/festi-admin/misc/', name: 'admin_misc')]
    public function index(): Response
    {
        return $this->render('misc/index.html.twig');
    }

    #[Route('/festi-admin/misc/logo', name: 'admin_misc_update_logo')]
    public function update_logo(Request $request): Response
    {
        $defaultData = ['allow_extra_fields' => true];

        $form = $this->createFormBuilder($defaultData)
            ->add('logo', FileType::class, [
                "attr" => [
                    "class" => "form-control",
                    "data-logo-input" => null,
                    'accept' => '.png',
                ],
                "label_attr" => ["class" => "form-control-label required"],
                "label" => "Logo",
                'required' => true,
                'help' => "Fichiers png en dessous de 2MB seulement",
                'constraints' => [
                    new Image([
                        'maxSize' => '2M', // 2048k
                        'mimeTypes' => MiscController::MIME_TYPES,
                        'mimeTypesMessage' => 'Merci de bien vouloir uploader une image correcte',
                    ])
                ],
            ])
            ->add('saveAndReturn', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-primary",
                    "form" => "form_edit_logo",
                    'label_html' => true,
                    
                ],
            ])
            ->add('saveAndContinue', SubmitType::class, [
                "attr" => [
                    "form" => "form_edit_logo",
                    "class" => "btn btn-secondary",
                ],
                'label_html' => true,
                // "label" => "<i class='action-icon far fa-edit'></i> Sauvegarder et modifier"
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                try {
                    $logoFile->move(
                        $this->getParameter('images_directory'),
                        "logo-talents-iut.png"
                    );
                } catch (FileException $e) {
                    dump($e->getMessage());
                }
            }

            $this->addFlash('success', 'Le logo a été mis à jour');
            /** @var ClickableInterface $button  */
            if ($form->get('saveAndReturn')->isClicked()) {
                return $this->redirectToRoute("admin_misc");
            }
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
