<?php

namespace Barcodes\Bundle\AppBundle\Structure\Doctrine\ORM;

use Exception;
use Barcodes\Bundle\AppBundle\Entity\Pricingrule;
use Akeneo\Tool\Component\StorageUtils\Exception\InvalidObjectException;
use Akeneo\Tool\Component\StorageUtils\Exception\InvalidPropertyException;
use Akeneo\Tool\Component\StorageUtils\Updater\ObjectUpdaterInterface;
use Doctrine\Common\Util\ClassUtils;
use \DateTime;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;


class PricingruleUpdater implements ObjectUpdaterInterface
{
    public function update($pricingrule, array $data, array $options = [])
    {
        if (!$pricingrule instanceof Pricingrule) {
            throw InvalidObjectException::objectExpected(
                ClassUtils::getClass($pricingrule),
                Pricingrule::class
            );
        }

        foreach ($data as $field => $value) {
            $this->setData($pricingrule, $field, $value);
        }

        return $this;
    }

    /**
     * @param Pricingrule $pricingrule
     * @param string $field
     * @param mixed $data
     *
     * @throws InvalidPropertyException
     * @throws Exception
     */
    protected function setData(Pricingrule $pricingrule, $field, $data)
    {
        switch ($field) {
            case 'manufacturer':
                $pricingrule->setManufacturer($data);
                break;
            case 'category':
                $pricingrule->setCategory($data);
                break;
            case 'product':
                $pricingrule->setProduct($data);
                break;
            case 'pricetype':
                $pricingrule->setPricetype($data);
                break;
            case 'operator':
                $pricingrule->setOperator($data);
                break;
            case 'value':
                $pricingrule->setValue($data);
                break;
            case 'channel':
                $pricingrule->setChannel($data);
                break;
            case 'createdAt':
                $pricingrule->setCreatedAt(new DateTime('now'));
                break;
            case 'updatedAt':
                $pricingrule->setUpdatedAt(new DateTime('now'));
                break;
        }
    }
}