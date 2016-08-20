<?php
/*class ElicoCorp_Catalog_Block_Product extends Mage_Catalog_Block_Product {
    public function getPriceHtml($product)
    {
        $this->setTemplate('catalog/product/price.phtml');
        $this->setProduct($product);
		if(Mage::getSingleton('customer/session')->isLoggedIn())
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
            if($groupId == 1)
                return "";
	        return $this->toHtml();
		return "";
    }
}
?>
