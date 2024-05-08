<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GenresController extends AbstractController
{

  public function __construct(
    private GenreRepository $genreRepository,
    private SerializerInterface $serializer

  ) {
  }
    #[Route('/genres', methods: ['GET'])]
  public function list(): JsonResponse
  {
    $genres = $this->genreRepository->findAll();
    if (empty($genres)) {
      // Risposta con codice di stato 204 No Content
      return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
    $data = $this->serializer->serialize($genres, "json", ["groups" => "default"]);

    return new JsonResponse($data, json: true);
  }
}
