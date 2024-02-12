<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Service\CartValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/validate')]
    public function validate(
        CartRepository $repository,
        CartValidator $validator,
    ): Response {
        // récupération du panier courant
        $cart = new Cart();
        $purchase = $validator->createPurchase($cart);

        return $this->redirect('/');
    }
}
