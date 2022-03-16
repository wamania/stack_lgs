<?php

namespace App\Repository;

use App\Entity\Variant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Variant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variant[]    findAll()
 * @method Variant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Variant::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Variant $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Variant $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param int[] $ids
     * @return Variant[]
     */
    public function findByProductIds(array $ids): array
    {
        return $this->createQueryBuilder('v')
            ->join('v.product', 'p')
            ->where('v.product IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}
