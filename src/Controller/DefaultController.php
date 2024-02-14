<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Form\PurchaseType;
use App\Service\PurchaseDeliverer;
use App\Service\StatsProcessor;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
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

    #[Route('/demo-type-guesser', methods: ['GET', 'POST'])]
    public function demoTypeGuesser(
        Request $request,
        MailerInterface $mailer,
        PurchaseDeliverer $deliverer,
    ): Response {
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        $attachedContent = 'file content';

        if ($form->isSubmitted() && $form->isValid()) {
            $deliverer->deliver($purchase);
            $message = (new TemplatedEmail())
                ->to('recipient@example.com')
                ->from('noreply@example.com')
                ->subject('My subject')
                ->textTemplate('mail/purchase.txt.twig')
                ->htmlTemplate('mail/purchase.html.twig')
                ->context([
                    'phone_number' => $purchase->getCustomerPhone()
                ])
                ->attach($attachedContent, 'filename.ext', 'text/plain')
                ->attachFromPath('/dev/null')
                ->addPart((new DataPart(fopen('/dev/null', 'r'), 'company-logo', 'image/webp'))->asInline())
            ;

            $mailer->send($message);
        }

        return $this->render('default/demo_type_guesser.html.twig', [
            'form' => $form,
        ]);
    }
}
