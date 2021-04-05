<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Transaction;
use App\Classes\WishList;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class OrderController
 * @package App\Controller
 * @Route("/order")
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

    public function __construct
    (
        EntityManagerInterface $entityManager,
        Security $security,
        Cart $cart,
        WishList $wishlist
    )
    {
        $this->entityManager = $entityManager;
        $this->cart = $cart;
        $this->security = $security;
        $this->wishlist = $wishlist;
    }

    /**
     * @Route("/", name="order")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        if (!empty($this->cart->get())) {
            $this->cart->switch();
        }
        if ($request->get('from') != null) {
            $user = $this->security->getUser();
            $order = $this->entityManager->getRepository(Order::class)->findOneBy([
                'customer' => $user,
                'stripeSessionId' => null
            ]);
        }else {
            if (empty($request->request->all())) {
                $order = new Order();
            } else {
                $id = $request->request->get('order')["id"];
                $order = $this->entityManager->getRepository(Order::class)->find($id);
            }
        }
        $form = $this->createForm(OrderType::class, $order);

        return $this->render('order/checkout.html.twig', [
            'form' => $form->createView(),
            'cart' => $this->cart->getFull($this->cart->get()),
            'wishlist' => $this->wishlist->getFull(),
            'cart2order' => $this->cart->getFull($this->cart->getCart2Order()),
            'delivery' => $this->cart->getDelivery(),
            'delivery2order' => $this->cart->getDelivery2Order(),
            'page' => 'checkout'
        ]);
    }

    /**
     * @Route("/ar", name="order.ar")
     * @param Request $request
     * @return Response
     */
    public function indexAr(Request $request): Response
    {

        if (!empty($this->cart->get())) {
            $this->cart->switch();
        }
        if ($request->get('from') != null) {
            $user = $this->security->getUser();
            $order = $this->entityManager->getRepository(Order::class)->findOneBy([
                'customer' => $user,
                'stripeSessionId' => null
            ]);
        }else {
            if (empty($request->request->all())) {
                $order = new Order();
            } else {
                $id = $request->request->get('order')["id"];
                $order = $this->entityManager->getRepository(Order::class)->find($id);
            }
        }
        $form = $this->createForm(OrderType::class, $order);

        return $this->render('order/checkoutAr.html.twig', [
            'form' => $form->createView(),
            'cart' => $this->cart->getFull($this->cart->get()),
            'wishlist' => $this->wishlist->getFull(),
            'cart2order' => $this->cart->getFull($this->cart->getCart2Order()),
            'delivery' => $this->cart->getDelivery(),
            'delivery2order' => $this->cart->getDelivery2Order(),
            'page' => 'checkout.ar'
        ]);
    }

    /**
     * @Route("/recap/", name="order.recap")
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function add(Request $request, Transaction $transaction): Response
    {
            $id = $request->request->get('order')["id"];
            if ($id == "") {
                $order = new Order();
                if ($this->cart->checkStock()) {
                    $this->cart->decreaseStock();
                } else {
                    return $this->redirectToRoute('back.to.cart');
                }

            } else {
                $order = $this->entityManager->getRepository(Order::class)->find($id);
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
                    $subTotal = $product['quantity'] * $product['catalog']->getProduct()->getPrice();
                    $orderDetail = new OrderDetails();
                    $orderDetail->setMyOrder($order);
                    $orderDetail->setProduct($product['catalog']->getProduct()->getName());
                    $orderDetail->setSize($product['catalog']->getSize());
                    $orderDetail->setQuantity($product['quantity']);
                    $discount = $product['catalog']->getProduct()->getDiscountPrice();
                    $price = ($discount != null || $discount != 0) ? $discount : $product['catalog']->getProduct()->getPrice();
                    $orderDetail->setPrice($price);
                    $orderDetail->setTotal($subTotal);
                    $this->entityManager->persist($orderDetail);
                    $total += $subTotal;
                }
                $order->setTotal($total);
            }

            $this->entityManager->flush();
            return $this->render('order/checkout-two.html.twig', [
                    'cart' => $this->cart->getFull($this->cart->get()),
                    'wishlist' => $this->wishlist->getFull(),
                    'cart2order' => $this->cart->getFull($this->cart->getCart2Order()),
                    'order' => $order,
                    'page' => 'order.recap',
                    'form' => $this->createForm(OrderType::class, $order)->createView()
                ]
            );

        }

        return $this->redirectToRoute('cart');

    }

    /**
     * @Route("/recap/ar", name="order.recap.ar")
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function addAr(Request $request, Transaction $transaction): Response
    {
        $id = $request->request->get('order')["id"];
        if ($id == "") {
            $order = new Order();
            if ($this->cart->checkStock()) {
                $this->cart->decreaseStock();
            } else {
                return $this->redirectToRoute('back.to.cart.ar');
            }

        } else {
            $order = $this->entityManager->getRepository(Order::class)->find($id);
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
                    $subTotal = $product['quantity'] * $product['catalog']->getProduct()->getPrice();
                    $orderDetail = new OrderDetails();
                    $orderDetail->setMyOrder($order);
                    $orderDetail->setProduct($product['catalog']->getProduct()->getName());
                    $orderDetail->setSize($product['catalog']->getSize());
                    $orderDetail->setQuantity($product['quantity']);
                    $discount = $product['catalog']->getProduct()->getDiscountPrice();
                    $price = ($discount != null || $discount != 0) ? $discount : $product['catalog']->getProduct()->getPrice();
                    $orderDetail->setPrice($price);
                    $orderDetail->setTotal($subTotal);
                    $this->entityManager->persist($orderDetail);
                    $total += $subTotal;
                }
                $order->setTotal($total);
            }

            $this->entityManager->flush();
            return $this->render('order/checkout-twoAr.html.twig', [
                    'cart' => $this->cart->getFull($this->cart->get()),
                    'wishlist' => $this->wishlist->getFull(),
                    'cart2order' => $this->cart->getFull($this->cart->getCart2Order()),
                    'order' => $order,
                    'page' => 'order.recap.ar',
                    'form' => $this->createForm(OrderType::class, $order)->createView()
                ]
            );

        }

        return $this->redirectToRoute('cart.ar');

    }

    /**
     * @Route("/back-to-cart", name="back.to.cart")
     * @return Response
     */
    public function back(): Response
    {
        $this->cart->reverseSwitch();
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/back-to-cart-ar", name="back.to.cart.ar")
     * @return Response
     */
    public function backAr(): Response
    {
        $this->cart->reverseSwitch();
        return $this->redirectToRoute('cart.ar');
    }
}