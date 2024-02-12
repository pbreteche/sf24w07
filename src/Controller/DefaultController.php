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

    #[Route('/admin/global-stats')]
    public function heavyProcess(
        StatsProcessor $processor,
        CacheItemPoolInterface $pool,
    ): Response {
        $stats = $pool->get('app_default_heavyprocess', function (CacheItemInterface $item) use ($processor) {
            $item->expiresAfter(new \DateInterval('PT1H'));

            return $processor->compute();
        });

        return $this->json(['result' => $stats]);
    }
}
