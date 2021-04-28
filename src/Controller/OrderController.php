<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Transaction;
use App\Classes\WishList;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class OrderController
 * @package App\Controller
 */
class OrderController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var WishList
     */
    private $wishlist;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct
    (
        EntityManagerInterface $entityManager,
        Security $security,
        Cart $cart,
        WishList $wishlist,
        CategoryRepository $categoryRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->cart = $cart;
        $this->security = $security;
        $this->wishlist = $wishlist;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/{locale}/order", name="order", defaults={"locale"="en"})
     * @param $locale
     * @return Response
     */
    public function index($locale): Response
    {

        if (!empty($this->cart->get())) {
            $this->cart->switch();
        }else{
            if(empty($this->cart->getCart2Order()))
            return $this->redirectToRoute('cart', ['locale' => $locale]);
        }
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $path = ($locale == "en") ? 'order/checkout.html.twig' : 'order/checkoutAr.html.twig';
        return $this->render($path, [
            'form' => $form->createView(),
            'cart' => $this->cart->getFull($this->cart->get()),
            'total' => $this->cart->getTotal(),
            'wishlist' => $this->wishlist->getFull(),
            'cart2order' => $this->cart->getFull($this->cart->getCart2Order()),
            'delivery' => $this->cart->getDelivery(),
            'delivery2order' => $this->cart->getDelivery2Order(),
            'page' => 'checkout',
            'categories' => $this->categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/{locale}/order/recap/", name="order.recap", defaults={"locale"="en"})
     * @param $locale
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function add($locale, Request $request, Transaction $transaction): Response
    {
        $order = new Order();
        if ($this->cart->checkStock()) {
            $this->cart->decreaseStock();
        } else {
            return $this->redirectToRoute('back.to.cart', ['locale' => $locale]);
        }
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($order->getId() == null) {
                $date = new \DateTime();
                /** @var Customer $user */
                $user = $this->getUser();
                $reference = $date->format('Ymd') . '-' . uniqid();
                $order->setReference($reference);
                $order->setCustomer($user);
                $order->setCreatedAt($date);
                $order->setDeliveryPrice($this->cart->getDelivery2Order());
                $transaction->applyWorkFlow($order, 'create_order');
                $this->entityManager->persist($order);
                $total = 0.0;
                foreach ($this->cart->getFull($this->cart->getCart2Order()) as $product) {
                    $subTotal = $product['quantity'] * $product['product']->getPrice();
                    $orderDetail = new OrderDetails();
                    $orderDetail->setMyOrder($order);
                    $orderDetail->setProduct($product['product']->getName());
                    $orderDetail->setQuantity($product['quantity']);
                    $discount = $product['product']->getDiscountPrice();
                    $price = ($discount != null || $discount != 0) ? $discount : $product['product']->getPrice();
                    $orderDetail->setPrice($price);
                    $orderDetail->setTotal($subTotal);
                    $this->entityManager->persist($orderDetail);
                    $total += $subTotal;
                }
                $order->setTotal($total);
            }

            $this->entityManager->flush();
            return $this->redirectToRoute('my.fatoorah.create.session', [
                    'id' => $order->getId(),
                ]
            );

        }

        return $this->redirectToRoute('cart', ['locale' => $locale]);

    }

    /**
     * @Route("/{locale}/order/back-to-cart", name="back.to.cart", defaults={"locale"="en"})
     * @param $locale
     * @return Response
     */
    public function back($locale): Response
    {
        $this->cart->reverseSwitch();
        return $this->redirectToRoute('cart', ['locale' => $locale]);
    }

}
