<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Yaml\Yaml;

use App\Service\DefaultValues;

class MiscController extends DashboardController
{
    private const MIME_TYPES = [
        'image/png',
    ];

    #[Route('/festi-admin/misc/', name: 'admin_misc')]
    public function index(): Response
    {
        $file_path = "{$this->getParameter('data_directory')}/main.yml";
        $main_data_file = Yaml::parseFile($file_path);

        return $this->render('misc/index.html.twig', [
            'event_name' => DefaultValues::getEventName($main_data_file)
        ]);
    }

    #[Route('/festi-admin/misc/logo', name: 'admin_misc_update_logo', methods: ['GET', 'POST'])]
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
                'help' => "<b>Fichiers png en dessous de 2MB seulement</b>",
                'help_html' => true,
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
                    "class" => "btn btn-primary bg-btn-primary",
                    "form" => "form_edit_logo",
                ],
            ])
            ->add('saveAndContinue', SubmitType::class, [
                "attr" => [
                    "form" => "form_edit_logo",
                    "class" => "btn btn-secondary",
                ],
                'label_html' => true,
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

    #[Route('/festi-admin/misc/event', name: 'admin_misc_update_event_name', methods: ['GET', 'POST'])]
    public function update_event_name(Request $request): Response
    {
        $defaultData = ['allow_extra_fields' => true];

        $file_path = "{$this->getParameter('data_directory')}/main.yml";
        $main_data_file = Yaml::parseFile($file_path);

        $form = $this->createFormBuilder($defaultData)
            ->add('event_name', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                ],
                "label_attr" => ["class" => "form-control-label"],
                "label" => "Nom",
                'required' => true,
                'data' => $main_data_file["event_name"],
                'constraints' => [
                    new NotBlank()
                ],
            ])
            ->add('saveAndReturn', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-primary bg-btn-primary",
                    "form" => "form_edit_logo",
                ],
            ])
            ->add('saveAndContinue', SubmitType::class, [
                "attr" => [
                    "form" => "form_edit_logo",
                    "class" => "btn btn-secondary",
                ],
                'label_html' => true,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            unset($main_data_file["allow_extra_fields"]);
            $event_new_name = $form->getData()["event_name"]; 

            $main_data_file["event_name"] = $event_new_name;

            file_put_contents($file_path, Yaml::dump($main_data_file));

            $this->addFlash('success', "Le nom du festival est devenu <b>{$event_new_name}</b>");
            /** @var ClickableInterface $button  */
            if ($form->get('saveAndReturn')->isClicked()) {
                return $this->redirectToRoute("admin_misc");
            }
        }

        return $this->render('misc/form-event-name.html.twig', [
            'form' => $form,
        ]);
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }
}
