<?php

namespace App\Controller\Rest;

use App\Repository\TShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/t-shirt')]
class TShirtController extends AbstractController
{
    #[Route('/', methods: 'GET')]
    public function index(
        TShirtRepository $repo,
    ): JsonResponse {
        $tShirts = $repo->findBy([], limit: 50);

        return $this->json($tShirts);
    }
}
