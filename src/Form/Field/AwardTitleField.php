<?php

namespace App\Form\Field;

use App\Form\Type\AwardTitleType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AwardTitleField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            // ->setTemplateName('crud/field/integesr')
            ->setFormType(AwardTitleType::class)
            // ->setTemplatePath('back/award-title-input.html.twig')
            ->setDefaultColumns('col-md-4 col-xxl-3')
            ;
    }
}
