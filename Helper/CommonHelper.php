<?php

namespace Ow\Bundle\OwEnhancedRelationListBundle\Helper;

use eZ\Publish\API\Repository\Repository;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Helper class for building many things :-)
 */
class CommonHelper extends ContainerAware {

    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    public function __construct( Repository $repository ) {
        $this->repository = $repository;
    }

    /**
     * @param $content \eZ\Publish\Core\Repository\Values\Content\Content
     * @param $attributeName string content attribute name
     * @param $localeEz string language
     * @return owEnhancedRelationList object
     */
    public function getFieldValue( $content, $attributeName, $localeEz = '' ) {
        $locationService = $this->repository->getLocationService();
        $contentService = $this->repository->getContentService();

        if (!$localeEz) {
            $localeConverter = $this->container->get('ezpublish.locale.converter');
            $localeEz = $localeConverter->convertToEz($this->container->get('request')->getLocale());
        }

        $owEnhancedRelationListFieldValue = $content->getFieldValue($attributeName, $localeEz);

        if ($owEnhancedRelationListFieldValue) {
            foreach ($owEnhancedRelationListFieldValue->destinationLocationIds as $k => $locationId) {
                $relationLocation = $locationService->loadLocation($locationId);
                $relationContent = $contentService->loadContentByContentInfo($relationLocation->getContentInfo());

                if ($relationLocation->hidden
                     || $relationLocation->invisible
                     || (!in_array($localeEz, $relationContent->getVersionInfo()->languageCodes) && !$relationLocation->getContentInfo()->alwaysAvailable)
                ) {
                    // Entry not available => don't return this
                    unset($owEnhancedRelationListFieldValue->destinationContentIds[$k]);
                    unset($owEnhancedRelationListFieldValue->destinationLocationIds[$k]);
                }
            }
        }

        return $owEnhancedRelationListFieldValue;
    }

}
