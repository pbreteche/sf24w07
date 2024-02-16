<?php

namespace App\Controller\Rest;

use App\Entity\TShirt;
use App\Repository\TShirtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/t-shirt')]
class TShirtController extends AbstractController
{
    #[Route('/', methods: 'GET')]
    public function index(
        TShirtRepository $repo,
    ): JsonResponse {
        $tShirts = $repo->findBy([], limit: 50);

        return $this->json($tShirts, context: ['groups' => 't-shirt-index']);
    }

    #[Route('/{referenceNumber}', methods: 'GET')]
    public function show(
        TShirt $tShirt,
    ): JsonResponse {
        return $this->json($tShirt, context: ['groups' => 't-shirt']);
    }

    #[Route('/', methods: 'POST')]
    public function new(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
    ): Response {
        $tShirt = $serializer->deserialize($request->getContent(), TShirt::class, JsonEncoder::FORMAT);
        $violations = $validator->validate($tShirt);
        if (0 < $violations->count()) {
            return $this->json($violations, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $entityManager->persist($tShirt);
        $entityManager->flush();

        return $this->redirectToRoute('app_rest_tshirt_show', [
            'referenceNumber' => $tShirt->getReferenceNumber(),
        ]);
    }


}
