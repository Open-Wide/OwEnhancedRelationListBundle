=========================================================
OwEnhancedRelationListBundle for eZ Publish documentation
=========================================================

.. image:: https://github.com/Open-Wide/OWEnhancedSelection/raw/master/doc/images/Open-Wide_logo.png
    :align: center

:Extension: OW Enhanced RelationList v1.0
:Requires: eZ Publish 5.x.x (not tested on 3.X)
:Author: Open Wide http://www.openwide.fr


Presentation
============

This bundle provides a data type for single or multiple relations with more advanced features than the default, such as min and max items in the relation

Bundle eZPublish 5 for OwEnhancedRelationList extension

see https://github.com/Open-Wide/OwEnhancedRelationList


Installation
============

At first, you have to enable the bundle :

.. code-block:: php

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Ow\Bundle\OwEnhancedRelationListBundle\OwEnhancedRelationListBundle(),
        // ...
    );


Usage
=====
Add an owenhancedrelationlist attribute in your content class with all the parameters you need.


Twig
----

.. code-block:: html+jinja

    {% set values = owenhancedrelationlist_ez_field_value(content, "my_field") %}

PHP
---

.. code-block:: php

    // $container is an instance of "service_container"
    $commonHelper = $container->get( 'owenhancedrelationlist.common_helper' );
    $values = $commonHelper->getFieldValue( $content, "my_field" );

