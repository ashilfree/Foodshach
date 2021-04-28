<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Mailer;
use App\Classes\Transaction;
use App\Classes\WishList;
use App\Entity\Order;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{

	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var Transaction
	 */
	private $transaction;
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var WishList
     */
    private $wishlist;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, Transaction $transaction, Cart $cart, WishList $wishlist, Mailer $mailer, CategoryRepository $categoryRepository)
	{
		$this->entityManager = $entityManager;
		$this->transaction = $transaction;
        $this->cart = $cart;
        $this->mailer = $mailer;
        $this->wishlist = $wishlist;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/order/thank/{reference}", name="order.validate.thank")
     * @param $reference
     * @param Request $request
     * @return Response
     */
    public function success($reference, Request $request): Response
    {
	    $order = $this->entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);
		if(!$order || $order->getCustomer() != $this->getUser()){
			return $this->redirectToRoute('home');
		}

		if ($this->transaction->check($order, 'checkout')){
			$this->cart->remove2Order();
			$this->transaction->applyWorkFlow($order, 'checkout');
            $order->setPaidAt(new \DateTime());
			$this->entityManager->flush();
            $this->mailer->sendSuccessOrderEmail($order);
		}

        return $this->render('order/order-complete.html.twig', [
        	'order' => $order,
            'cart' => $this->cart->getFull($this->cart->get()),
            'total' => $this->cart->getTotal(),
            'categories' => $this->categoryRepository->findAll(),
            'wishlist' => $this->wishlist->getFull(),
            'page' => 'order-complete'
        ]);
    }

    /**
     * @Route("/order/error/{reference}", name="order.validate.error")
     * @param $reference
     * @return Response
     */
	public function cancel($reference): Response
	{
		$order = $this->entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);
		if(!$order || $order->getCustomer() != $this->getUser()){
			return $this->redirectToRoute('home');
		}
		if ($this->transaction->check($order, 'checkout_canceled'))
			$this->transaction->applyWorkFlow($order, 'checkout_canceled');
        $this->cart->increaseStock();
        $this->cart->remove2Order();
        $order->setCancelledAt(new \DateTime());
		$this->entityManager->flush();
        $this->mailer->sendFailureOrderEmail($order);
		return $this->render('order/order-canceled.html.twig', [
			'order' => $order,
            'cart' => $this->cart->getFull($this->cart->get()),
            'total' => $this->cart->getTotal(),
            'categories' => $this->categoryRepository->findAll(),
            'wishlist' => $this->wishlist->getFull(),
            'page' => 'order-canceled'
		]);
	}
}
