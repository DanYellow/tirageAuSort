<?php

namespace App\Form\Type;

use App\Entity\EloquenceContestParticipant;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EloquenceContestParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder->add('id', HiddenType::class);

        $builder->add('lastname', TextType::class, [
            'label' => '<span class="text-blue-900">Nom de famille *</span>',
            "label_html" => true,
            'mapped' => true,
            'required' => true,
            'help' => 'Champ requis',
        ]);
        $builder->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'mapped' => true,
            'required' => true,
            'help' => 'Champ requis',
        ]);
        $builder->add('formation', EntityType::class, [
            'class' => Formation::class,
            'autocomplete' => true,
            'mapped' => true,
            'placeholder' => 'Choisissez un nom dans la liste',
        ]);
        $builder->add('is_active', CheckboxType::class, [
            'label' => 'Participe au concours ?',
            // 'mapped' => true,
            'empty_data' => true,
            'required' => false,
            // 'attr' => array('checked' => 'checked', 'value' => '1')
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EloquenceContestParticipant::class,
            "allow_extra_fields" => true,
        ]);
    }
}
