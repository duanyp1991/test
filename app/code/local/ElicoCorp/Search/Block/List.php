<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class ElicoCorp_Search_Block_List extends Mage_Catalog_Block_Product_List
{

    protected function _getProductCollection()
    {

        if (is_null($this->_productCollection)) {
            $layer = $this->getLayer();
            /* @var $layer Mage_Catalog_Model_Layer */
            if ($this->getShowRootCategory()) {
                $this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
            }


            $origCategory = null;
            if (isset($_POST['category']) and !empty($_POST['category']))  {
                $category = Mage::getModel('catalog/category')->load((int)$_POST['category']);
                $origCategory = $layer->getCurrentCategory();
                $layer->setCurrentCategory($category);
            }

        

            $this->_productCollection = $layer->getProductCollection();

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }


        }
	$fields = unserialize(SEARCH_FIELDS);
        $multiple_fields = unserialize(SEARCH_FIELDS_MULTIPLE);
        foreach($fields as $field) {
            if(isset($_POST[$field]) and !empty($_POST[$field])) {
                if(in_array($field, $multiple_fields) == True) {
                	$this->_productCollection->addAttributeToFilter(array(array('attribute' => $field, 'eq' => $_POST[$field]),
				array('attribute' => $field, 'like' => '%,'.$_POST[$field].'%'),
				array('attribute' => $field, 'like' => '%'.$_POST[$field].',%')));
		}
		else {
                	$this->_productCollection->addAttributeToFilter($field, array('eq' => $_POST[$field]));
		}
	    }
        }
       return $this->_productCollection;
    }

   
}
