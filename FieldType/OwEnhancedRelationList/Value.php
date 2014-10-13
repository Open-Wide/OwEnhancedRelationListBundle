<?php
namespace Ow\Bundle\OwEnhancedRelationListBundle\FieldType\OwEnhancedRelationList;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * Related content id's
     *
     * @var mixed[]
     */
    public $destinationContentIds;

    /**
     * Construct a new Value object and initialize it $text
     *
     * @param mixed[] $destinationContentIds
     */
    public function __construct( array $destinationContentIds = array() )
    {
        $this->destinationContentIds = $destinationContentIds;
    }

    /**
     * @see \eZ\Publish\Core\FieldType\Value
     */
    public function __toString()
    {
        return implode( ',', $this->destinationContentIds );
    }
}