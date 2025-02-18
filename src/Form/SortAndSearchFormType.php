<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class SortAndSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sort = array(
            'Domyślnie' => null,
            'Cena rosnąco' =>'sellingPrice-asc',
            'Cena malejąco' =>'sellingPrice-desc',
            'Nazwa A-Z' => 'name-asc',
            'Nazwa Z-A' => 'name-desc'
        );

        $builder
            ->add('sort', ChoiceType::class, [
                'label' => 'Sortuj według: ',
                'choices'  => [$sort],
            ])
            ->add('search', TextType::class, [
                'label' => 'Szukaj: ',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zatwierdź'
            ]);
        $builder->setMethod('GET');
    }
}
