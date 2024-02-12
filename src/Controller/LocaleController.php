<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LocaleController extends AbstractController
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function displayLocaleForm(
        array $acceptedLanguage,
    ): Response {
        $form = $this->buildForm($acceptedLanguage);

        return $this->render('locale/select_locale.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/locale', methods: 'POST')]
    public function selectLocale(
        Request $request,
        array $acceptedLanguage,
    ): Response {
        $form = $this->buildForm($acceptedLanguage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $request->getSession()->set('_locale', $form->getData());
        }

        return $this->redirect($request->headers->get('referer', '/'));
    }

    private function buildForm(array $acceptedLanguage): FormInterface
    {
        return $this->createForm(LocaleType::class, options: [
            'choices' => $acceptedLanguage,
            'choice_loader' => null,
            'choice_label' => Languages::getName(...),
            'action' => $this->urlGenerator->generate('app_locale_selectlocale'),
        ]);
    }
}
