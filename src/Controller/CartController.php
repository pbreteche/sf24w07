<?php

namespace App\Controller;

use App\Repository\CartRepository;
use App\Service\CartValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/validate', methods: 'POST')]
    public function validate(
        CartRepository $repository,
        CartValidator $validator,
    ): Response {
        // récupération du panier courant
        $cart = $repository->find(1);
        $purchase = $validator->createPurchase($cart);

        return $this->redirect('url de la page de règlement');
    }
}