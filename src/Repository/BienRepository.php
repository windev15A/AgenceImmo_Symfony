<?php

namespace App\Repository;

use App\Data\FilterData;
use App\Entity\Bien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bien>
 *
 * @method Bien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bien[]    findAll()
 * @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

    public function save(Bien $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bien $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Bien[] Returns an array of Bien objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bien
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getData(int $limit = 5): mixed
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.created_at', 'desc')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param FilterData $filter
     * @return array
     */
    public function searchBien(FilterData $filter):array
    {
        try {
            $query = $this->createQueryBuilder('b')
                ->select("b", "t", "c")
                ->join("b.category", "c")
                ->join("b.type", "t");

            if ($filter->q) {
                $query = $query
                    ->andWhere("b.description LIKE :q")
                    ->orWhere("b.ville LIKE :q")
                    ->orWhere("c.label LIKE :q")
                    ->orWhere("t.libelle LIKE :q")
                    ->setParameter("q", "%$filter->q%");
            }
            if ($filter->categories) {
                $query = $query
                    ->andWhere("c.id IN (:categories)")
                    ->setParameter("categories", $filter->categories);
            }
            if ($filter->types) {
                $query = $query
                    ->andWhere("t.id IN (:types)")
                    ->setParameter("types", $filter->types);
            }
            if ($filter->priceMin) {
                $query = $query
                    ->andWhere("b.price >= :min")
                    ->setParameter('min', $filter->priceMin);
            }
            if ($filter->priceMax) {
                $query = $query
                    ->andWhere("b.price <= :max")
                    ->setParameter('max', $filter->priceMax);
            }
            if ($filter->surfaceMin) {
                $query = $query
                    ->andWhere("b.surface >= :min")
                    ->setParameter('min', $filter->surfaceMin);
            }
            if ($filter->surfaceMax) {
                $query = $query
                    ->andWhere("b.surface <= :max")
                    ->setParameter('max', $filter->surfaceMax);
            }

            return $query
                ->getQuery()
                ->getResult();

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
