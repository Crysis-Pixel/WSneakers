<?php
class CartService{
    public static $instance;
    public function AddCart(Cart $cart, Product $product){
        $cartRepo = CartRepo::getInstance();
        $isCartSuccess = $cartRepo->AddCart($cart);
        if($isCartSuccess)
        {
            $cart->setCartID($cartRepo->getCartID($cart->getCustomerID()));
            $cartRepo->AddToConsistsOf($cart, $product);
        }
    }

    public static function getInstance() : CartService {
        if (!isset(CartService::$instance)) {
            CartService::$instance = new CartService();
        }

        return CartService::$instance;
    }
}
?>