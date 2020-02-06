<?php


namespace Barcodes\Bundle\AppBundle\Entity;


use Akeneo\Tool\Component\StorageUtils\Model\ReferableInterface;
use Akeneo\Tool\Component\Versioning\Model\TimestampableInterface;
use Akeneo\Tool\Component\Versioning\Model\VersionableInterface;

interface PricingruleInterface extends
    TimestampableInterface,
    ReferableInterface,
    VersionableInterface
{
    /**
     * Set Id
     *
     * @param integer $id
     *
     * @return BrandInterface
     */
    public function setId($id);

}