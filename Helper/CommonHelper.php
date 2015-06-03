<?php

namespace Ow\Bundle\OwEnhancedRelationListBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAware;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\Values\Content\Field;

/**
 * Helper class for building many things :-)
 */
class CommonHelper extends ContainerAware {

    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param $content \eZ\Publish\Core\Repository\Values\Content\Content
     * @param $attributeName string content attribute name
     * @param $localeEz string language
     * @return owEnhancedRelationList object
     */
    public function getFieldValue($content, $attributeName, $localeEz = '') {
        $translationHelper = $this->container->get('ezpublish.translation_helper');
        $field = $translationHelper->getTranslatedField($content, $attributeName);
        if ($field instanceof Field) {
            $value = $field->value;
            $locationService = $this->repository->getLocationService();
            foreach ($value->destinationLocationIds as $k => $locationId) {
                $relationLocation = $locationService->loadLocation($locationId);
                if ($relationLocation) {
                    if ($relationLocation->invisible) {
                        // Entry not available => don't return this
                        unset($value->destinationContentIds[$k]);
                        unset($value->destinationLocationIds[$k]);
                    }
                } else {
                    unset($value->destinationContentIds[$k]);
                    unset($value->destinationLocationIds[$k]);
                }
            }
            return $value;
        }
    }

}
