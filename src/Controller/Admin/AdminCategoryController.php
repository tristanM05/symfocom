<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index(CategoryRepository $repo_category): Response
    {
        $categories = $repo_category->findAll();
        return $this->render('Admin/admin_category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/category/new", name="admin_category_new")
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     */
    public function addEditCategory(EntityManagerInterface $manager, Request $req, Category $category = null, SubCategoryRepository $sub_repo, ArticlesRepository $repo_article){

        if(!$category){
            $category = new Category();
        }
        $subCategory = $sub_repo->findBy(['category' => $category]);
        $idCategory = $category->getId();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'Catégorie enregistrée avec succès');
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('Admin/admin_category/add_edit_category.html.twig', [
            'form' => $form->createView(),
            'editMode' => $category->getId() !== null,
            'category' => $category,
            'subCategory' => $subCategory,
        ]);
    }

}
