<?php

namespace Barcodes\Bundle\AppBundle\Structure\Component\Normalizer\Versioning;

use Barcodes\Bundle\AppBundle\Entity\PricingruleInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * A normalizer to transform a pricingrule into a flat array
 */
class PricingruleNormalizer implements NormalizerInterface
{
    const ITEM_SEPARATOR = ',';
    const UNIT_LABEL_PREFIX = 'conversion_unit';

    /** @var string[] */
    protected $supportedFormats = ['flat'];

    /** @var NormalizerInterface */
    protected $standardNormalizer;

    /**
     * @param NormalizerInterface $standardNormalizer
     */
    public function __construct(
        NormalizerInterface $standardNormalizer
    )
    {
        $this->standardNormalizer = $standardNormalizer;
    }

    /**
     * {@inheritdoc}
     *
     * @param PricingruleInterface $pricingrule
     *
     * @return array
     */
    public function normalize($pricingrule, $format = null, array $context = [])
    {
        $standardPricingrule = $this->standardNormalizer->normalize($pricingrule, 'standard', $context);

        $flatPricingrule = $standardPricingrule;
        $flatPricingrule['locales'] = implode(self::ITEM_SEPARATOR, $standardPricingrule['locales']);

        return $flatPricingrule;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PricingruleInterface && in_array($format, $this->supportedFormats);
    }
}