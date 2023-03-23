<?php

namespace App\Form;

use App\Data\FilterData;
use App\Entity\Category;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                "required" => false,
                "label" => "Titre de l'annonce",
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                ]
            ])
            ->add('ville', TextType::class, [
                "required" => false,
                "attr" => [
                    "class" => "mt-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                ]
            ])
            ->add('priceMin', IntegerType::class,
                [
                    "required" => false,
                    "label" => 'Min',
                    "attr" => [
                        "class" => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    ]
                ])
            ->add('priceMax', IntegerType::class,
                [
                    "required" => false,
                    "label" => 'Max',
                    "attr" => [
                        "class" => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    ]
                ])
            ->add('surfaceMin', NumberType::class,
                [
                    "required" => false,
                    "label" => 'Min',
                    "attr" => [
                        "class" => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    ]
                ])
            ->add('surfaceMax', NumberType::class,
                [
                    "required" => false,
                    "label" => 'Max',
                    "attr" => [
                        "class" => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    ]
                ])
            ->add('categories', EntityType::class, [
                "required" => false,
                "class" => Category::class,
                "choice_label" => "label",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('types', EntityType::class, [
                "required" => false,
                "class" => Type::class,

                "choice_label" => "libelle",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('save', SubmitType::class, [
                'label' => "Recherche",
                'attr' => [
                    'class' => 'w-full mt-10 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-md px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800'
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterData::class
        ]);
    }
}
