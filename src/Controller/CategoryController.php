<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_category')]
    public function index(
        $slug,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $category = $categoryRepository->findOneBySlug($slug);

        if (!$category) {
            return $this->redirectToRoute('app_home');
        }

        $searchTerm = $request->query->get('q');

        // Création de la requête de base
        $query = $searchTerm
            ? $productRepository->getSearchInCategoryQuery($category, $searchTerm)
            : $productRepository->createQueryBuilder('p')
                ->where('p.category = :category')
                ->setParameter('category', $category)
                ->getQuery();

        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de page
            9 // Limite par page
        );

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
