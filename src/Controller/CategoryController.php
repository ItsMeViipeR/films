<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route("/category", name: "app_category")]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render("category/index.html.twig", [
            "categories" => $categories,
        ]);
    }

    #[Route("/category/edit/{id}", name: "category_edit", requirements: ["id" => "\d+"], methods: ["GET", "POST"])]
    public function edit(Category $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("success", "Catégorie modifiée avec succès !");

            return $this->redirectToRoute("app_category");
        }

        return $this->render("category/edit.html.twig", [
            "form" => $form,
            "category" => $category,
        ]);
    }
}
