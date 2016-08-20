<?php
class ElicoCorp_Catalog_Block_Product_Price extends Mage_Catalog_Block_Product_Price   {
    
    protected function _toHtml()
    {
        $customer = Mage::getSingleton('customer/session');
        if(!$customer->isLoggedIn())
            return "";
        $groupId = $customer->getCustomerGroupId();
        if($groupId == 1)
            return "";
        if (!$this->getProduct() || $this->getProduct()->getCanShowPrice() === false) {
            return '';
        }
        return parent::_toHtml();
    }
}
?>