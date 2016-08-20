<?php
echo "<h1>Yo</h1>";

class ElicoCorp_Catalog_Block_Product_Status extends Mage_Core_Block_Template {
    
    /**
     * Retrieve product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        $product = $this->_getData('product');
        if (!$product) {
            $product = Mage::registry('current_product');
        }
        return $product;
    }
 
    protected function _toHtml()
    {
        if (!$this->getProduct()) {
            return 'noa';
        }
        return parent::_toHtml();
    }

}
