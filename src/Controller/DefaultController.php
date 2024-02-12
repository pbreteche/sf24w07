<?php

namespace App\Controller;

use App\Service\StatsProcessor;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function heavyProcess(
        StatsProcessor $processor,
        CacheItemPoolInterface $pool,
        int $year = null,
    ): Response {
        $year ??= date('Y');

        $stats = $pool->get(sprintf('app_default_heavyprocess_%04d', $year), function (CacheItemInterface $item) use ($processor) {
            $item->expiresAfter(new \DateInterval('PT1H'));

            return $processor->compute();
        });

        return $this->json(['result' => $stats]);
    }
}
