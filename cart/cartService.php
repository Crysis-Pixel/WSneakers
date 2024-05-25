<?php
session_start();

class CartService{
    public static $instance;
    public function AddCart($productID, $quantity){
        $cartRepo = CartRepo::getInstance();
        $productService = new ProductService;
        $result = $productService->GetProduct($productID);
        if($result)
        {
            $row = $result->fetch_assoc();
            $availableQuantity = $row["Quantity"];
        }
        $customerID = $_SESSION["CustomerID"];
        $cart = Cart::create()
        ->retrieveOldCart($customerID)
        ->setCustomerID($customerID)
        ->addProductID($productID, $quantity);
        
        if($availableQuantity < $cart->getQuantity()[$productID])
        {
            echo "Not Enough Stock! ";
        } else
        {
            $isCartSuccess = $cartRepo->Add($cart, $productID);
            if($isCartSuccess)
            {
                echo "CART ADDED!";
            }
        }
        
    }

    public function CartRetrievePrice(Cart $cart)
    {
        $prices = $cart->getPriceOfProduct();
        $productIDs = $cart->getProductIDs();
        $cartRepo = CartRepo::getInstance();

        $prices = $cartRepo->GetCartProductPrices($cart, $productIDs);
        if($prices)
        {
            $cart->setPriceOfProduct($prices);
        }
    }
    public function CartRetrieveName(Cart $cart)
    {
        $names = $cart->getProductName();
        $productIDs = $cart->getProductIDs();
        $cartRepo = CartRepo::getInstance();

        $names = $cartRepo->GetCartProductNames($cart, $productIDs);
        if($names)
        {
            $cart->setProductName($names);
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