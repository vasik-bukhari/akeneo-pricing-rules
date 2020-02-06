<?php

namespace Barcodes\Bundle\AppBundle\Structure\Component\Normalizer\Standard;

use Barcodes\Bundle\AppBundle\Entity\PricingruleInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PricingruleNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($pricingrule, $format = null, array $context = [])
    {
        if (is_array($pricingrule)) {
            $normalizedElements = [];

            foreach ($pricingrule as $element) {
                $normalizedElements[] = array(
                    'id' => $element->getId(),
                    'manufacturer' => $element->getManufacturer(),
                    'category' => $element->getCategory(),
                    'product' => $element->getProduct(),
                    'pricetype' => $element->getPricetype(),
                    'operator' => $element->getOperator(),
                    'value' => $element->getValue(),
                    'channel' => $element->getChannel(),
                    'updatedAt' => $element->getUpdatedAt(),
                    'updatedAt' => $element->getUpdatedAt()
                );
            }

            return $normalizedElements;
        } elseif (!$pricingrule->getId()) {
            return ['manufacturer' => $pricingrule->getManufacturer(), 'category' => $pricingrule->getCategory(), 'product' => $pricingrule->getProduct(), 'pricetype' => $pricingrule->getPricetype(), 'operator' => $pricingrule->getOperator(), 'value' => $pricingrule->getValue(), 'channel' => $pricingrule->getChannel(), ];
        } else {
            return [
                'id' => $pricingrule->getId(),
                'manufacturer' => $pricingrule->getManufacturer(),
                'category' => $pricingrule->getCategory(),
                'product' => $pricingrule->getProduct(),
                'pricetype' => $pricingrule->getPricetype(),
                'operator' => $pricingrule->getOperator(),
                'value' => $pricingrule->getValue(),
                'channel' => $pricingrule->getChannel(),
                'createdAt' => $pricingrule->getCreatedAt(),
                'updatedAt' => $pricingrule->getUpdatedAt(),
                'meta' => array(
                    'id'         => $pricingrule->getId(),
                    'created'    => $pricingrule->getCreatedAt(),
                    'updated'    => $pricingrule->getUpdatedAt()
                )
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PricingruleInterface && 'standard' === $format;
    }
}
