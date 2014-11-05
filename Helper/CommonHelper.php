<?php

namespace Ow\Bundle\OwEnhancedRelationListBundle\Helper;

use eZ\Publish\API\Repository\Repository;

/**
 * Helper class for building many things :-)
 */
class CommonHelper {

    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    public function __construct( Repository $repository ) {
        $this->repository = $repository;
    }

    /**
     * @param $content \eZ\Publish\API\Repository\Values\Content
     * @param $attributeName string content attribute name
     * @return owEnhancedRelationList object
     */
    public function getFieldValue( $content, $attributeName ) {
        $locationService = $this->repository->getLocationService();
        $owEnhancedRelationListFieldValue = $content->getFieldValue($attributeName);

        foreach ($owEnhancedRelationListFieldValue->destinationLocationIds as $k => $locationId) {
            $location = $locationService->loadLocation($locationId);
            if ($location->hidden || $location->invisible) {
                // Entry not visible => don't return this location !
                unset($owEnhancedRelationListFieldValue->destinationContentIds[$k]);
                unset($owEnhancedRelationListFieldValue->destinationLocationIds[$k]);
            }
        }
        return $owEnhancedRelationListFieldValue;
    }

}
