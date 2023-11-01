<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmFormType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/', name: 'app_film')]
    public function index(FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findAll();

        return $this->render('film/index.html.twig', [
            "films" => $films,
        ]);
    }

    #[Route("/film/new", name: "film_new", methods: ["GET", "POST"])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $film = new Film();

        $form = $this->createForm(FilmFormType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();

            $this->addFlash('success', 'Nouveau post créé avec succès');
            return $this->redirectToRoute('app_film');
        }

        return $this->render('film/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/film/edit/{id}", name: "film_edit", requirements: ["id" => "\d+"], methods: ['GET', 'POST'])]
    public function edit(Film $film, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(FilmFormType::class, $film);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute("app_film");
        }

        return $this->render("film/edit.html.twig", [
            "form" => $form,
            'film' => $film,
        ]);
    }

    #[Route("/film/show/{id}", name: "film_show", requirements: ["id" => "\d+"], methods: ["GET"])]
    public function show(Film $film,): Response
    {
        return $this->render("film/show.html.twig", [
            "film" => $film,
        ]);
    }

    #[Route("/film/delete/{id}", name: "film_delete", requirements: ["id" => "\d+"], methods: ["POST"])]
    public function delete(Film $film, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->request->get('_token'))) {
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_film');
    }
}
