<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class SortFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sort = array(
            'Domyślnie' => null,
            'Cena rosnąco' =>'price-asc',
            'Cena malejąco' =>'price-desc',
            'Nazwa A-Z' => 'name-asc',
            'Nazwa Z-A' => 'name-desc'
        );

        $builder
            ->add('Sortuj:', ChoiceType::class, [
                'choices'  => [$sort],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Szukaj'
            ]);
        $builder->setMethod('GET');
    }
}
