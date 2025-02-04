<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/category/new', name: 'new_category')]
    #[Route('/category/{id}/edit', name: 'edit_category')]
    public function new_category(Request $request,EntityManagerInterface $entityManager, Category $category = null)//HTTP Fondation
    {
        if (!$category) {
                $category = new Category();
            }
        
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);//On prend en charge la requête demandée 

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est envoyé et valide

            $category = $form->getData();//Recuperation des données du formulaire

            $entityManager->persist($category);//Similaire à pdo->prepare

            $entityManager->flush();//Similaire à pdo->execute

            return $this->redirectToRoute('app_category');//Redirection vers la liste des catégories
        }
        
        return $this->render('category/new.html.twig', [
            'formAddCategory' => $form,
            'edit'=>$category->getId()
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Course $course , Category $category) : Response
    {
        return $this->render('category/show.html.twig',[
            'course' => $course,
            'category' => $category
        ]);
    }

    #[Route('/category/{id}/delete', name: 'delete_category')]
    public function delete(Category $category, EntityManagerInterface $entityManager) : Response
    {
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute('app_category');
    }
}
