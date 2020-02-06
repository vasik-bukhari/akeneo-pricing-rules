<?php

namespace Barcodes\Bundle\AppBundle\Repository;

use Akeneo\Tool\Component\StorageUtils\Repository\IdentifiableObjectRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Brand repository interface
 *
 */
interface PricingruleRepositoryInterface extends IdentifiableObjectRepositoryInterface, ObjectRepository
{
    /**
     * Return the number of brands
     *
     * @return int
     */
    public function countAll(): int;
}
