<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * Return the latest properties ordered by creation date.
     *
     * @param int $limit
     * @return Property[]
     */
    public function findLatest(int $limit = 6): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
