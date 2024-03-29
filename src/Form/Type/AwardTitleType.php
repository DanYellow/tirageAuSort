<?php

namespace App\Form\Type;

use App\Entity\Award;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AwardTitleType extends AbstractType
{
    // public function buildForm(FormBuilderInterface $builder, array $options): void
    // {
    //     // dump($builder);
    //     // exit;

    //     // $builder->add(
    //     //     $builder->create('title', TextType::class, [
    //     //         'label' => 'Nom de famille',
    //     //         "label_html" => true,
    //     //         'mapped' => true,
    //     //         'required' => true,
    //     //         'help' => 'Champ requis',
    //     //         "data"=>"fefe",
    //     //         'constraints' => [
    //     //             new NotBlank([]),
    //     //         ],
    //     //     ])->addModelTransformer(new CallbackTransformer(
    //     //         function($imageUrl) {
    //     //             return null;
    //     //         },
    //     //         function($imageUrl) {
    //     //             dump($imageUrl);
    //     //             return $imageUrl->getTitle();
    //     //         }
    //     //     ))

    //     // $builder->add('title', TextType::class);
    //         // ->addModelTransformer(new CallbackTransformer(
    //         //     function ($imageUrl) {
    //         //         return null;
    //         //     },
    //         //     function ($imageUrl) {

    //         //         return $imageUrl;
    //         //     }
    //         // ));
    //         // $builder->add('title');

    //     // // );
    //     // $builder->create('title', TextType::class, [
    //     //     'label' => 'Nom de famille',
    //     //     "label_html" => true,
    //     //     'mapped' => true,
    //     //     'required' => true,
    //     //     'help' => 'Champ requis',
    //     //     // "data"=>"fefe",
    //     //     'constraints' => [
    //     //         new NotBlank([]),
    //     //     ],
    //     // ])->addModelTransformer(new CallbackTransformer(
    //     //     function($imageUrl) {
    //     //         return null;
    //     //     },
    //     //     function($imageUrl) {
    //     //         dump($imageUrl);
    //     //         return $imageUrl;
    //     //     }
    //     // ));
    // }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => true,
            'constraints' => [
                new NotBlank([]),
            ],
            'required' => true,
            'attr' => ['type' => "text"]
            // 'data_class' => Award::class,
        ]);
    }

    // public function gettitle() {
    //     return "fffz";
    // }

    public function getBlockPrefix()
    {
        return 'award_title';
    }
}
