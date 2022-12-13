<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;

class ContentController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('content/index.html.twig', [
            'controller_name' => 'ContentController',
        ]);
    }

    #[Route('/product', name: 'app_index_product', methods: ['GET'])]
    public function showAllProduct(ProductRepository $productRepository): Response
    {
        return $this->render('content/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    
    #[Route('product/{id}', name: 'app_product_show', methods: ['GET'])]
    public function showProduct(Product $product): Response
    {
        return $this->render('content/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/category', name: 'app_category_index', methods: ['GET'])]
    public function showAllCategory(CategoryRepository $categoryRepository): Response
    {
        return $this->render('content/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show', methods: ['GET'])]
    public function showCategory(Category $category): Response
    {
        return $this->render('content/category/show.html.twig', [
            'category' => $category,
        ]);
    }

}
