<?php

namespace App\Repository;

use App\Entity\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Supplier $entity, bool $flush = true): void
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
    public function remove(Supplier $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Supplier[]
     */
    public function list(?string $sku, ?string $reference): array
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s');

        if (null !== $sku) {
            $qb
                ->join('s.products', 'p')
                ->join('p.variants', 'v')
                ->andWhere('v.sku = :sku')
                ->setParameter('sku', $sku);
        }

        if (null !== $reference) {
            $qb
                ->join('s.products', 'p')
                ->andWhere('p.reference = :reference')
                ->setParameter('reference', $reference);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
