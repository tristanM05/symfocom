<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSubCategoryController extends AbstractController
{
    /**
     * @Route("/admin/subCategory/new}", name="admin_subCategory_new")
     * @Route("/admin/subCategory/edit/{id}", name="admin_subCategory_edit")
     */
    public function addEditSubCategory(EntityManagerInterface $manager, Request $req, SubCategory $subCategory = null){

        if(!$subCategory){
            $subCategory = new SubCategory();
        }
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($subCategory);
            $manager->flush();
            $this->addFlash('success', 'Sous-catégorie enregistrée avec succès');
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('Admin/admin_sub_category/add_edit_subCategory.html.twig', [
            'form' => $form->createView(),
            'editMode' => $subCategory->getId() !== null,
            'subCategory' => $subCategory,
        ]);
    }
}
