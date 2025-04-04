<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use App\Repository\CategoryRepository;
//use App\Service\CategoryService;


class SortAndSearchFormType extends AbstractType
{
//    public function __construct(
//        private CategoryRepository $categoriesRepository,
//        private CategoryService    $categoryService
//    )
//    {
//        $this->CategoriesRepository = $categoriesRepository;
//    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
//            'csrf_field_name' => '_token',
//            'csrf_token_id'   => 'task_item',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sort = array(
            'Domyślnie' => null,
            'Cena rosnąco' =>'selling_price-asc',
            'Cena malejąco' =>'selling_price-desc',
            'Nazwa A-Z' => 'name-asc',
            'Nazwa Z-A' => 'name-desc'
        );

//        $category = array('Wszystko' => '%') + $this->categoryService->getNameAndIdCategory();

        $builder
            ->add('sort', ChoiceType::class, [
                'label' => 'Sortuj według: ',
                'choices'  => [$sort],
            ])
//            ->add('category', ChoiceType::class, [
//                'label' => 'Kategoria: ',
//                'choices'  => [$category],
//            ])
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
