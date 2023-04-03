<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

#[Route('/category', name: 'category_')]
Class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categories' => $categories]
        );
    }

    #[Route('/{categoryName}', name: 'show', requirements: ['categoryName' => '\w+'])]
    public function show(string $categoryName, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
    
        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune catégorie nommée '.$categoryName.' trouvée en base de données.'
            );
        }
    
        $programs = $programRepository->findBy(
            ['category' => $category],
            ['id' => 'DESC'],
            3
        );
    
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }
}
