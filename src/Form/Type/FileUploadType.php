<?php

namespace App\Form\Type;

use App\Entity\EloquenceContestParticipant;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;

class FileUploadType implements FieldInterface
{
    use FieldTrait;

    // ... lines 11 - 12
    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/image')
            ->setFormType(FileType::class)
            ->addCssClass('field-image')
            ->setDefaultColumns('col-md-4 col-xxl-3')
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-image.js'), Asset::fromEasyAdminAssetPackage('field-file-upload.js'))
            ->setFormTypeOption(
                'constraints',
                [
                    new File([
                        'mimeTypes' => [ // We want to let upload only jpeg or png
                            'application/vnd.ms-excel',
                            'text/csv',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ],
                    ])
                ]
            )
            ->setHtmlAttributes(['accept' => '.xls,.xlsx,.csv'])
            ;
    }
}
