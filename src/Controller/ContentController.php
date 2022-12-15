<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\CartProducts;
use App\Repository\CartProductsRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use App\Form\CartProductType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;


class ContentController extends AbstractController
{
    public function __construct(protected ManagerRegistry $registry)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        //dd($productRepository->findAll());
        return $this->render('content/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product', name: 'app_index_product', methods: ['GET'])]
    public function showAllProduct(ProductRepository $productRepository): Response
    {
        return $this->render('content/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    
    #[Route('/product/{id}', name: 'app_product_show', methods: ['GET'])]
    public function showProduct(Request $request, Product $product, CartProductsRepository $cartProductsRepository): Response
    {
        /** @var User $user **/
        $user = $this->getUser();
        
        
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


    #[Route('/subcategory', name: 'app_sub_category_index', methods: ['GET'])]
    public function showAllSubCategory(SubCategoryRepository $subCategoryRepository): Response
    {
        return $this->render('content/sub_category/index.html.twig', [
            'sub_categories' => $subCategoryRepository->findAll(),
        ]);
    }

    #[Route('/subcategory/{id}', name: 'app_sub_category_show', methods: ['GET'])]
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('content/sub_category/show.html.twig', [
            'sub_category' => $subCategory,
        ]);
    }
   
}