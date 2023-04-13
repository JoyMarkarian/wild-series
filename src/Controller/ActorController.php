<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActorRepository;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
  
  #[Route('/', name: 'index')]
  public function index(ActorRepository $actorRepository): Response
  {
    $actors = $actorRepository->findAll();

    return $this->render('actor/index.html.twig', [
        'actors' => $actors,
    ]);
  }

  #[Route('/{id}', name: 'show')]
  public function show(Actor $actor): Response
  {
    if (!$actor) {
        throw $this->createNotFoundException(
            'No actor with id : '.$actor.' found in actor\'s table.'
        );
    }
    return $this->render('actor/show.html.twig', [
        'actor' => $actor,
        'programs' => $actor->getPrograms()
    ]);
}
}
