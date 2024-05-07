<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

  //    /**
  //     * @return Movie[] Returns an array of Movie objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('m')
  //            ->andWhere('m.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('m.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?Movie
  //    {
  //        return $this->createQueryBuilder('m')
  //            ->andWhere('m.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
  /**
   * Restituisce tutti i film  o con ordinamento per data di rilascio e valutazione.
   *
   * @param string|null $release Ordine di rilascio ("ASC" o "DESC")
   * @param string|null $rating  Ordine di valutazione ("ASC" o "DESC")
   *
   * @return Movie[]
   */
  public function findAll($release = null, $rating = null): array
  {
    $query = $this->createQueryBuilder('m');

    $this->applyOrdering($query, $release, $rating);

    return $query
      ->getQuery()
      ->getResult();
  }

  /**
   * Restituisce tutti i film di un determinato genere e' possibile ordinarlo per per data di rilascio e valutazione.
   *
   * @param string      $genre   Genere del film
   * @param string|null $release Ordine di rilascio ("ASC" o "DESC")
   * @param string|null $rating  Ordine di valutazione ("ASC" o "DESC")
   *
   * @return Movie[]
   */
  public function findByGenre(array $genres, $release = null, $rating = null): array
  {
    $query = $this->createQueryBuilder('m')
      ->leftJoin('m.movieGenres', 'mg')
      ->leftJoin('mg.genre', 'g');
    foreach ($genres as $index => $genre) {
      $query->orWhere("g.name = :genre$index")
      ->setParameter("genre$index", $genre);
    }

    $this->applyOrdering($query, $release, $rating);

    return $query
      ->getQuery()
      ->getResult();
  }

  private function applyOrdering($query, $release, $rating): void
  {

    if (strtoupper($rating) === 'ASC' || strtoupper($rating) === 'DESC') {
      $query->OrderBy('m.rating', $rating);
    }

    if (strtoupper($release === 'ASC') || strtoupper($release) === 'DESC') {

      $query->AddOrderBy('m.releaseDate', $release);

    }

  }




}
