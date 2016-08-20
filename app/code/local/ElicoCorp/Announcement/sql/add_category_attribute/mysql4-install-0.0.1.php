<?php
$this->startSetup();
$this->addAttribute('catalog_category', 'is_announcement', array(
    'group'         => 'General Information',
    'input'         => 'checkbox',
    'type'          => 'int',
    'label'         => 'Is Announcement?',
    'backend'       => '',
    'visible'       => true,
    'required'      => false,
    'visible_on_front' => true,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));
 
$this->endSetup();
