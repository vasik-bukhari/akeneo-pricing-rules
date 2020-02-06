<?php

namespace Barcodes\Bundle\AppBundle\Structure\Doctrine\ORM\Repository;

use Barcodes\Bundle\AppBundle\Structure\Doctrine\ORM\Repository\PricingruleRepositoryInterface;
use Akeneo\Tool\Component\StorageUtils\Repository\CursorableRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Brand repository
 *
 */
class PricingruleRepository extends EntityRepository implements PricingruleRepositoryInterface,
    CursorableRepositoryInterface
{


    /**
     * {@inheritdoc}
     */
    public function countAll(): int
    {
        $qb = $this->createQueryBuilder('b')
            ->select('count(b.id)');

        return (int) $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByIdentifier($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByCode($product)
    {
        return $this->findOneBy(['product' => $product]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifierProperties()
    {
        return ['id'];
    }

    /**
     * @inheritDoc
     */
    public function getItemsFromIdentifiers(array $products)
    {
        $qb = $this->createQueryBuilder('b')

            ->where('b.product IN (:products)')
            ->setParameter('products', $products);

        $query = $qb->getQuery();
        $query->useQueryCache(false);

        return $query->execute();
    }
}
