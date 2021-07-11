<?php

namespace App\Classes;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;

class OrderCleanup{

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Transaction
     */
    private $transaction;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository, ProductRepository $productRepository, Transaction $transaction)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->transaction = $transaction;
        $this->entityManager = $entityManager;
    }

    public function clean(): int
    {
        $date = (new \DateTime());
//        $date->setTimezone(new DateTimeZone('Asia/Kuwait'));
        $date->sub(new \DateInterval('PT5M'));

        $orders = $this->orderRepository->getOrdersToClean($date);


        foreach ($orders as $order){
            if($this->transaction->check($order, 'order_canceled2'))
                $this->transaction->applyWorkFlow($order, 'order_canceled2');
            if($this->transaction->check($order, 'order_canceled'))
                $this->transaction->applyWorkFlow($order, 'order_canceled');
            foreach ($order->getOrderDetails() as $orderDetail){
                $product = $this->productRepository->findOneBy(['name'=> $orderDetail->getProduct()]);
                $newQuantity = $product->getQuantity() + $orderDetail->getQuantity();
                $product->setQuantity($newQuantity);
            }
            $this->entityManager->flush();
        }

        return count($orders);
    }
}