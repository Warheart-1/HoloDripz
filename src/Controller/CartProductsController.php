<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\CartProducts;
use App\Repository\CartProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/** 
 * @var Cart $cart
 * **/

class CartProductsController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_products', methods: ['POST,GET'])]
    public function addProduct(Request $request, Product $product, CartProductsRepository $cartProductsRepository): Response
    {
        /** @var User $user **/
        $user = $this->getUser();
        $cart = $user->getCart();
        $cp = $cart->getCartsProducts()->toArray();

        if(empty($cp)){
            $cartProduct = new CartProducts();
            $cartProduct->setCart($cart);
            $cartProduct->setProduct($product);
            $cartProduct->setQuantity(1);
            $cartProductsRepository->save($cartProduct, true);
            return $this->redirectToRoute('app_cart_products');
        }
        if(!empty($cp)){
            foreach($cp as $c){
                if($c->getProduct()->getId() == $product->getId()){
                    $c->setQuantity($c->getQuantity() + 1);
                    $cartProductsRepository->save($c, true);
                    break;
                }
            }
            $cartProduct = new CartProducts();
            $cartProduct->setCart($cart);
            $cartProduct->setProduct($product);
            $cartProduct->setQuantity(1);
            $cartProductsRepository->save($cartProduct, true);
            return $this->redirectToRoute('app_cart_products');
        }


        return $this->render('content/product/index.html.twig', [
            'controller_name' => 'CartProductsController',
        ]);
    }
}
