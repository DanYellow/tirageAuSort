<?php

namespace App\Form\Field;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;

class FileUploadField implements FieldInterface
{
    use FieldTrait;

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
