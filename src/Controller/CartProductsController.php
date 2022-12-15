<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\CartProducts;
use App\Entity\User;
use App\Repository\CartProductsRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

/** 
 * @var Cart $cart
 * **/

class CartProductsController extends AbstractController
{
    public function __construct(protected ManagerRegistry $registry)
    {
    }
    #[Route('/cart/add/{id}', name: 'app_cart_products_add', methods: ['GET'])]
    public function addProduct(Request $request, Product $product, CartProductsRepository $cartProductsRepository): Response
    {
        /** @var User $user **/
        $user = $this->getUser();
        $cart = $user->getCart();
        $cp = $cart->getCartProducts()->toArray();

        if(empty($cp)){
            $cartProduct = new CartProducts();
            $cartProduct->setCart($cart);
            $cartProduct->setProduct($product);
            $cartProduct->setQuantity(1);
            $cartProductsRepository->save($cartProduct, true);
            return $this->redirectToRoute('app_index_product');
        }
        if(!empty($cp)){
            foreach($cp as $c){
                if($c->getProduct()->getId() == $product->getId()){
                    $c->setQuantity($c->getQuantity() + 1);
                    $cartProductsRepository->save($c, true);
                    return $this->redirectToRoute('app_index_product');
                }
            }
            $cartProduct = new CartProducts();
            $cartProduct->setCart($cart);
            $cartProduct->setProduct($product);
            $cartProduct->setQuantity(1);
            $cartProductsRepository->save($cartProduct, true);
            return $this->redirectToRoute('app_index_product');
        }


        return $this->render('content/product/index.html.twig', [
            'controller_name' => 'CartProductsController',
        ]);
    }

    #[Route('/cart/{id}', name: 'app_cart_products_show', methods: ['GET'])]
    public function showCart(User $user){
        $cart = $user->getCart();
        $cartProducts = $cart->getCartProducts()->toArray();
        return $this->render('content/cart/show.html.twig', [
            'cartProducts' => $cartProducts,
        ]);
    }

    #[Route('/cart/update', name: 'app_cart_update', methods: ['POST'])]
    public function updateCart(Request $request, CartProductsRepository $cartProductsRepository){
        $postRequest = $request->getContent();
        $quantiy = json_decode($postRequest, true);
        $cartProduct = $cartProductsRepository->findByIdProduct($quantiy['id']);
        $cartProduct->setQuantity($quantiy['quantity']);
        $cartProductsRepository->save($cartProduct, true);

        return new JsonResponse([
            'message' => 'success',
            'code' => 200,
        ], 200);
    }

    #[Route('/cart/delete', name: 'app_cart_delete', methods: ['POST'])]
    public function deleteCart(Request $request, CartProductsRepository $cartProductsRepository){
        $postRequest = $request->getContent();
        $quantiy = json_decode($postRequest, true);
        $cartProduct = $cartProductsRepository->findByIdProduct($quantiy['id']);
        $cartProductsRepository->remove($cartProduct, true);

        return new JsonResponse([
            'message' => 'success',
            'code' => 200,
        ], 200);
    }
}
