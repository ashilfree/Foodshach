<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\WishList;
use App\Repository\AboutRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{

    /**
     * @Route("/{locale}/about-us", name="about.us", defaults={"locale"="en"})
     * @param $locale
     * @param Cart $cart
     * @param WishList $wishlist
     * @param AboutRepository $aboutRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index($locale, Cart $cart, WishList $wishlist, AboutRepository $aboutRepository, CategoryRepository $categoryRepository): Response
    {
        $path = ($locale == "en") ? 'about/index.html.twig' : 'about/indexAr.html.twig';
        return $this->render($path, [
            'page' => 'about.us',
            'cart' => $cart->getFull($cart->get()),
            'total' => $cart->getTotal(),
            'wishlist' => $wishlist->getFull(),
            'about' => $aboutRepository->findAll()[0],
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
