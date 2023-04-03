<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;


#[Route('/program', name: 'program_')]
Class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
         $programs = $programRepository->findAll();

         return $this->render(
             'program/index.html.twig',
             ['programs' => $programs]
         );
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
public function show(int $id, ProgramRepository $programRepository):Response
{
    $program = $programRepository->findOneBy(['id' => $id]);
    // same as $program = $programRepository->find($id);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }
    return $this->render('program/show.html.twig', [
        'program' => $program,
        'seasons' => $program->getSeasons()
    ]);
}

#[Route('/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}', name: 'season_show')]
public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository):Response
{
    $program = $programRepository->findOneBy(['id' => $programId]);
    // same as $program = $programRepository->find($id);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$programId.' found in program\'s table.'
        );
    }
    $season = $program->getSeasons()[$seasonId - 1];
    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episodes' => $season->getEpisodes()
    ]);
}
    
    }