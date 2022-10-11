<?php


namespace App\Classes;

use App\Entity\Order;
use App\Entity\Product;
use App\Repository\CatalogRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add($id, $quantity)
    {
        $cart = $this->session->get('cart', []);
        if (empty($cart[$id])) {
            $cart[$id] = $quantity;
        }else{
            $cart[$id] += $quantity;
        }
        $this->session->set('cart', $cart);
        return $cart[$id];
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function getCart2Order()
    {
        return $this->session->get('cart2order');
    }

    public function setCoupon(array $coup)
    {
        $this->session->set('coupon', $coup);
    }

    public function getCoupon()
    {
        return $this->session->get('coupon');
    }

    public function removeCoupon()
    {
        $this->session->remove('coupon');
    }

    public function getDelivery()
    {
        return $this->session->get('delivery');
    }

    public function getDeliveryIndex()
    {
        return $this->session->get('delivery-index');
    }

    public function getDelivery2Order()
    {
        return $this->session->get('delivery2order');
    }

    public function getFull($cart): array
    {
//        dd($this->session->getId());
        $cartComplete = [];
        if (!empty($cart)) {
            foreach ($cart as $id => $quantity) {
                $cartProduct = $this->productRepository->find($id);
                if (!$cartProduct) {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $cartProduct,
                    'quantity' => $quantity
                ];

            }
        }
        return $cartComplete;
    }

    public function getTotal()
    {
        $total = 0;
        if (!empty($this->get())) {
            foreach ($this->get() as $id => $quantity) {
                $cartProduct = $this->productRepository->find($id);
                if (!$cartProduct) {
                    $this->delete($id);
                    continue;
                }
                $total += ($cartProduct->getDiscountPrice() == 0.0 )? $cartProduct->getPrice()* $quantity:$cartProduct->getDiscountPrice()* $quantity;

            }
        }
        return number_format($total/100, 2, '.', ' ');
    }

    public function remove()
    {
        $this->session->remove('cart');
        $this->session->remove('delivery');
    }

    public function remove2Order()
    {
        $this->session->remove('cart2order');
        $this->session->remove('delivery2order');
    }

    public function delete($id)
    {

        $cart = $this->session->get('cart');

        unset($cart[$id]);

        if (empty($cart[$id]))
            $this->session->remove('delivery');

        $this->session->set('cart', $cart);
    }

    public function update(array $all)
    {
        $cart = $this->session->get('cart');
        foreach ($all as $key => $value) {
            if (str_contains($key, "product-")) {
                $i = substr($key, -1);
                $cart[$all["product-" . $i]] = $all["quantity-" . $i];
            }
        }
        $this->session->set('cart', $cart);
        $this->session->set('delivery', $all['delivery']);
        $this->session->set('delivery-index', $all['delivery-index']);

    }

    public function switch()
    {
        $cart = $this->get();
        $delivery = $this->getDelivery();
        $this->session->set('cart2order', $cart);
        $this->session->set('delivery2order', $delivery);
        $this->remove();
    }

    public function reverseSwitch()
    {
        $cart = $this->getCart2Order();
        $delivery = $this->getDelivery2Order();
        $this->session->set('cart', $cart);
        $this->session->set('delivery', $delivery);
        $this->remove2Order();
    }

    public function checkStock(): bool
    {
        $return = true;
        $cart = $this->getCart2Order();
        if (!empty($cart)) {
            foreach ($cart as $id => $quantity) {
                $cartCatalog = $this->productRepository->find($id);
                if ($quantity > $cartCatalog->getQuantity()) {
                    $return = false;
                    break;
                }
            }
        }
        return $return;
    }

    public function decreaseStock()
    {
        $cart = $this->getCart2Order();
        if (!empty($cart)) {
            foreach ($cart as $id => $quantity) {
                $cartCatalog = $this->productRepository->find($id);
                $newQuantity = $cartCatalog->getQuantity() - $quantity;
                $cartCatalog->setQuantity($newQuantity);
            }
        }
    }

    public function increaseStock()
    {
        $cart = $this->getCart2Order();
        if (!empty($cart)) {
            foreach ($cart as $id => $quantity) {
                $cartCatalog = $this->productRepository->find($id);
                $newQuantity = $cartCatalog->getQuantity() + $quantity;
                $cartCatalog->setQuantity($newQuantity);
            }
        }
    }

    public function createCart2Order(Order $order)
    {
        $cart = [];
        foreach ($order->getOrderDetails() as $orderDetail){
            /**
             * @var Product $product
             */
            $product = $this->productRepository->findOneBy(['name' => $orderDetail->getProduct()]);
            $cart[$product->getId()] = $orderDetail->getQuantity();
        }
        $this->session->set('cart2order', $cart);
        $this->session->set('delivery2order', $order->getDeliveryPrice());
    }
}