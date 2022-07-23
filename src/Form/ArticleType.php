<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\ProductStatus;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('code', TextType::class, [
                'label' => 'Code',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    "class" => "content-description"
                ],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
            ])
            ->add('costPrice', NumberType::class, [
                'label' => 'Prix d\'achat',
                'required' => false,
            ])
            ->add('specialPrice', NumberType::class, [
                'label' => 'Prix spécial',
                'required' => false,
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
            ])
            ->add('productionDate', DateType::class, [
                "widget" => "single_text",
                'label' => 'Date de production',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'mapped' => false,
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('subCategory', EntityType::class, [
                'label' => 'Sous-catégorie',
                'required' => false,
                'class' => SubCategory::class,
                'choice_label' => 'title',
            ])
            ->add('productStatus', EntityType::class, [
                'label' => 'Sous-catégorie',
                'class' => ProductStatus::class,
                'choice_label' => 'title',
            ])
            ->add('isvisible', CheckboxType::class,[
                'label' => "Produit visible",
                'required' => false
            ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
