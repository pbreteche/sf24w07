<?php

namespace App\Controller;

use App\Service\StatsProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/')]
class DefaultController extends AbstractController
{
    #[Route]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/admin/global-stats/{year<\d{4}>}')]
    #[Cache(expires: '+1 hour')]
    public function heavyProcess(
        StatsProcessor $processor,
        TagAwareCacheInterface  $pool,
        int $year = null,
    ): Response {
        $year ??= date('Y');

        $stats = $pool->get(sprintf('app_default_heavyprocess_%04d', $year), function (ItemInterface $item) use ($processor) {
            $item->expiresAfter(new \DateInterval('PT1H'));
            $item->tag('heavy_process');

            return $processor->compute();
        });

        /* Autres caches :
         *
         * Doctrine Registry garde les entités durant une exécution
         * Doctrine Query Cache : cache le DQL produit par le query builder
         * HTTP Cache
         * config symfony, template twig, ...
         */
        $pool->invalidateTags(['heavy_process']);

        return $this->json(['result' => $stats]);
    }
}
