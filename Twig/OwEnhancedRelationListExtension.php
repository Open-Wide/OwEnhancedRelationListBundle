<?php

namespace Ow\Bundle\OwEnhancedRelationListBundle\Twig;

class OwEnhancedRelationListExtension extends \Twig_Extension {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array(
            'owenhancedrelationlist_ez_field_value' => new \Twig_Function_Method($this, 'getFieldValue'),
        );
    }

    /**
     * Replace ez_field_value by this function to return only published objects.
     * By default, eZ returns all objects
     * @param $content \eZ\Publish\API\Repository\Values\Content
     * @param $attributeName string content attribute name
     * @return owEnhancedRelationList object
     */
    public function getFieldValue($content, $field) {
        $commonHelper = $this->container->get( 'owenhancedrelationlist.common_helper' );
        return $commonHelper->getFieldValue( $content, $field );
    }

    public function getName() {
        return 'owenhancedrelationlist_extension';
    }
}