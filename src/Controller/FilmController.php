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
}
