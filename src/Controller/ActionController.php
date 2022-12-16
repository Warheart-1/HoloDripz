<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\User;
use App\Entity\CartProducts;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\SubCategoryType;
use App\Repository\CartProductsRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActionController extends AbstractController
{
    public function __construct(protected UserPasswordHasherInterface $passwordHasher, protected ManagerRegistry $registry)
    {
    
    }
    #[Route('product/create', name: 'app_create_product', methods: ['GET', 'POST'])]
    public function createProduct(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository, SubCategoryRepository $subCategoryRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());
            $product->setSeller($this->getUser());

            $productRepository->save($product, true);

            return $this->redirectToRoute('app_index_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('product/update/{id}', name: 'app_update_product', methods: ['GET', 'POST'])]
    public function updateProduct(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_index_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('product/delete/{id}', name: 'app_delete_product', methods: ['POST'])]
    public function deleteProduct(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_index_product', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('category/create', name: 'app_create_category', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('category/edit/{id}', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/category/delete/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/subcategory/create', name: 'app_sub_category_new', methods: ['GET', 'POST'])]
    public function createSubCategory(Request $request, SubCategoryRepository $subCategoryRepository): Response
    {
        $subCategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategoryRepository->save($subCategory, true);

            return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content/sub_category/new.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form,
        ]);
    }

    #[Route('/subcategory/edit/{id}', name: 'app_sub_category_edit', methods: ['GET', 'POST'])]
    public function editSubCategory(Request $request, SubCategory $subCategory, SubCategoryRepository $subCategoryRepository): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategoryRepository->save($subCategory, true);

            return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('content/sub_category/edit.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form,
        ]);
    }

    #[Route('/subcategory/delete/{id}', name: 'app_sub_category_delete', methods: ['POST'])]
    public function deleteSubCategory(Request $request, SubCategory $subCategory, SubCategoryRepository $subCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subCategory->getId(), $request->request->get('_token'))) {
            $subCategoryRepository->remove($subCategory, true);
        }

        return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/product/checkout', name: 'app_checkout', methods: ['GET'])]
    public function checkout(){
        return($this->render('content/product/checkout.html.twig'));
    }

    #[Route('/product/checkout/{id}', name: 'app_checkout_product', methods: ['POST'])]
    public function checkoutProduct(User $user): Response
    {
        $currentUser = $this->getUser();
        if($currentUser->getId() !== $user->getId()){
            return $this->redirectToRoute('app_index_product', [], Response::HTTP_SEE_OTHER);
        }
        $cart = $user->getCart()->getCartProducts()->getValues();
        $stripe = new StripeClient($this->getParameter('stripe_sk'));
        $price = $cart[0]->getProduct()->getPrice();
        $intent = $stripe->paymentIntents->create([
            'amount' => $price * 100,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
        ]);
        $output = [
            'clientSecret' => $intent->client_secret,
        ];
        
        return new JsonResponse($output);

        //return $this->redirectToRoute('app_index_product', [], Response::HTTP_SEE_OTHER);
    }
}
