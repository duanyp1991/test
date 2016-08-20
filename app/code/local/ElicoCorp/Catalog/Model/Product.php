<?php
class ElicoCorp_Catalog_Model_Product extends Mage_Catalog_Model_Product { 
    /**
     * Is product salable detecting by product type.
     *
     * @return bool
     */
    public function isSaleable()
    {
        if($this->getCustomStatus() == 5 && $this->getCustomProductQty() > 0 && Mage::getSingleton('customer/session')->isLoggedIn()){
            $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
            if($this->getCanSell() == True)
                return false;
    	    return $this->isSalable();
		}
		return false;
    }

    public function getCustomImageUrl($zoom = false, $id = 1) {
        if($zoom == true) {
            return IMAGE_SERVER.'zoom-'.$id.'-'.$this->getSku().'.jpg';
        }
        return IMAGE_SERVER.$id.'-'.$this->getSku().'.jpg';
    }

    public function getNbImages() {
        $data = file_get_contents(IMAGE_SERVER.'nb-'.$this->getSku());
        return $data;
    }

    public function getWebRotatePath() {
        $url = IMAGE_SERVER.'images/products/'.$this->getSku().'/360/config.xml';
        $headers = get_headers($url);
        $status = substr($headers[0], 9, 3);
        if($status != "404"){
            return $url;
        }
        return '';
    }


}
?>
