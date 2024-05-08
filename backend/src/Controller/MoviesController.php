<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class MoviesController extends AbstractController
{
    public function __construct(
        private MovieRepository $movieRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/movies', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $genres = $request->query->get('genres');
        $release = $request->query->get('release');
        $rating = $request->query->get('rating');


        if ($genres !== null && strtoupper($genres) !== 'NULL') {
            $genresList = explode(",", $genres);
           $movies = $this->movieRepository->findByGenre($genresList, $release, $rating);
        } else {
          $movies = $this->movieRepository->findAll($release, $rating);
        }

        if (empty($movies)) {
          // Risposta con codice di stato 204 No Content
          return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }
        $data = $this->serializer->serialize($movies, "json", ["groups" => "default"]);

        return new JsonResponse($data, json: true);
    }
}
