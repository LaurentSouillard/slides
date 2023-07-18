<?php

namespace App\Repository;

use App\Entity\Images;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Images>
 *
 * @method Images|null find($id, $lockMode = null, $lockVersion = null)
 * @method Images|null findOneBy(array $criteria, array $orderBy = null)
 * @method Images[]    findAll()
 * @method Images[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Images::class);
        $this->paginator = $paginator;
    }

    /*// On récupère les images en lien avec une recherche par catégorie
    /**
     * @return PaginationInterface
     */
   /* public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('images')
            ->select('categories', 'images')
            ->join('images.categorie', 'categories');

        if(!empty($search->categories)){
            $query = $query
                ->andWhere('categories.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            15
        );
    }*/

    public function add(Images $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Images $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByPosition()
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i')
        ->orderBy('i.position', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Images[] Returns an array of Images objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Images
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
