<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Images;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/article", name="admin_article")
     */
    public function index(ArticlesRepository $repo_article): Response
    {
        $articles = $repo_article->findAll();
        return $this->render('Admin/admin_article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @Route("/admin/article/{id}/edit", name="admin_article_edit")
     */
     public function addEditArticle(EntityManagerInterface $manger, Request $req, Articles $article = null){
        if(!$article){
            $article = new Articles();
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($req);
        $now = new \DateTime();
        if($form->isSubmitted() && $form->isValid()){

            // ADD IMAGES IN CASCADE 
            $images = $form->get('images')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $article->addImage($img);
            }

            $category = $form->get('category')->getData();
            $article->addCategory($category);
            $article->setCreatedAt($now);
            $manger->persist($article);
            $manger->flush();
            $this->addFlash('success', 'Article enregistré avec succès');
            return $this->redirectToRoute('admin_article');
        }
        return $this->render('Admin/admin_article/add_edit_article.html.twig', [
            'form' => $form->createView(),
            'editMode' => $article->getId() !== null,
            'article' => $article,
        ]);

     }

         /**
     * @Route("/admin/article/{id}", name="admin_article_show")
     */
    public function show($id): Response{
        return $this->render('Admin/admin_article/show.html.twig', [
            'controller_name' => 'AdminArticleController',
        ]);
    }
}
