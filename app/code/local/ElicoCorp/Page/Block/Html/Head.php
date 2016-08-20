<?php
class ElicoCorp_Page_Block_Html_Head extends Mage_Page_Block_Html_Head {
    protected function _construct()
    { 
	     $this->setTemplate('page/html/head.phtml');
		 // if ($this->helper('customer')->isLoggedIn())
			//  $this->check_client();
    }
	
	private function check_client() {

		// $customer_store = Mage::getSingleton('customer/session')->getCustomer()->getStore(); //Get Customers Group ID
		// $website_id = Mage::app()->getWebsite()->getId(); //Get Customers Group ID
		// if($website_id != $customer_store->getWebsite()) {
		// 	echo $customer_store->getBaseUrl();
		// }
		// $current_store =  Mage::app()->getStore();
		// if($group_id == 4 && $current_store->getId() != 1) {
		// 	$store = Mage::app()->getStore(1);
		// 	$url = $store->getBaseUrl()."?___store=".$store->getCode();
		// 	header('Location: '.$url);
		// 	exit;
		// } elseif($group_id != 4 && $current_store->getId() == 1) {
		// 	$store = Mage::app()->getStore(2);
		// 	$url = $store->getBaseUrl()."?___store=".$store->getCode();
		// 	header('Location: '.$url);
		// 	exit;
		// }
		
	}
}
	
?>