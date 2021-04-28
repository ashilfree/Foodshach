<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Filter;
use App\Classes\Search;
use App\Classes\WishList;
use App\Form\FilterArType;
use App\Form\FilterType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var WishList
     */
    private $wishlist;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository, Cart $cart, WishList $wishlist)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->cart = $cart;
        $this->wishlist = $wishlist;
    }

    /**
     * @Route("/{locale}/category/{slug}", name="category", defaults={"locale"="en"})
     * @param $locale
     * @param $slug
     * @return Response
     */
    public function show($locale, $slug): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slug]);
        if(!$category)
            return $this->redirectToRoute('home', ['locale' => $locale]);
        $products = $this->productRepository->findBy(['category'=>$category]);
        $path = ($locale == "en") ? 'page/index.html.twig' : 'page/index.html.twig';
        return $this->render($path, [
            'page' => 'category',
            'category' => $category,
            'categories' => $this->categoryRepository->findAll(),
            'products' => $products,
            'cart' => $this->cart->getFull($this->cart->get()),
            'total' => $this->cart->getTotal(),
            'showCart' => true,
            'wishlist' => $this->wishlist->getFull(),
        ]);
    }
}
