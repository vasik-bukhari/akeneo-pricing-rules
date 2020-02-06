<?php

namespace Barcodes\Bundle\AppBundle\Structure\Component\Normalizer\InternalApi;

use Akeneo\Tool\Bundle\VersioningBundle\Repository\VersionRepositoryInterface;
use Doctrine\Common\Util\ClassUtils;
use Barcodes\Bundle\AppBundle\Entity\PricingruleInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Pricingrule Normalizer
 */
class PricingruleNormalizer implements NormalizerInterface
{
    /** @var array $supportedFormats */
    protected $supportedFormats = ['internal_api'];

    /** @var NormalizerInterface */
    protected $pricingruleNormalizer;

    /** @var VersionRepositoryInterface */
    protected $versionRepository;

    /** @var NormalizerInterface */
    protected $versionNormalizer;

    /**
     * @param NormalizerInterface        $pricingruleNormalizer
     * @param VersionRepositoryInterface $versionRepository
     * @param NormalizerInterface        $versionNormalizer
     */
    public function __construct(
        NormalizerInterface $pricingruleNormalizer,
        VersionRepositoryInterface $versionRepository,
        NormalizerInterface $versionNormalizer
    ) {
        $this->pricingruleNormalizer = $pricingruleNormalizer;
        $this->versionRepository = $versionRepository;
        $this->versionNormalizer = $versionNormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($pricingrule, $format = null, array $context = [])
    {
        $normalizedPricingrule = $this->pricingruleNormalizer->normalize($pricingrule, 'standard', $context);

        $normalizedPricingrule['meta'] = array(
            'id'         => $pricingrule->getId(),
            // 'form'       => 'barcodes-pricing-edit-form',
            'created'    => $pricingrule->getCreatedAt(),
            'updated'    => $pricingrule->getUpdatedAt()
        );

        return $normalizedPricingrule;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PricingruleInterface && in_array($format, $this->supportedFormats);
    }
}