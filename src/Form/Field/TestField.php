<?php

namespace App\Form\Field;

use App\Entity\EloquenceContestParticipant;
use App\Entity\EloquenceSubject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class FoodAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => EloquenceContestParticipant::class,
            'searchable_fields' => ['firstname'],
            'label' => 'What sounds tasty?',
            'choice_label' => 'firstname',
            'multiple' => false,
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
