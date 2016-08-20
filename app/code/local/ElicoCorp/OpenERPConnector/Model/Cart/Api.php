<?php
class ElicoCorp_OpenERPConnector_Model_Cart_Api extends Mage_Checkout_Model_Api_Resource
{

    public function update($cartId, $data, $store = null) {
        $cart = Mage::getModel('sales/quote')
                ->getCollection()
                ->addFieldToFilter("entity_id",$cartId)
                ->getFirstItem();
        foreach($data['items'] as $item) {
            $line = Mage::getModel('sales/quote_item')
                ->getCollection()
                ->setQuote($cart)
                ->addFieldToFilter('product_id', $item['entity_id'])
                ->getFirstItem();
            $quantity = (int) $line->getQty();
            $removed_quantity = (int) $item['removed_quantity'];
            if($removed_quantity >= $quantity) {
                $line->delete();
            } else {
                $final_quantity = $quantity - $removed_quantity;
                $line->setQty($final_quantity);
                $line->save();
            }
        }
        return $this->info($cartId);
    }
    
    public function info($cartIds) {
    	$stores = array();

    	if(is_array($cartIds)) {
    	    foreach($cartIds as $cartId) {
    	        try {
    	        	$stores[] = $this->getCart($cartIds);
    	        }
                catch (Mage_Core_Exception $e) {
                    $this->_fault('cart_not_exists');
	            }
            }
            return $stores;
    	}
    	elseif(is_numeric($cartIds)) {
    	    try {
    // 	    	$cart = Mage::getModel('sales/quote')->getCollection()->addFieldToFilter("entity_id",$cartIds)->toArray();
				// return $cart['items'][0];

		    	return $this->getCart($cartIds);

			}
            catch (Mage_Core_Exception $e) {
                $this->_fault('cart_not_exists');
            }
        }

    }

    public function search($filters = array(),$store_view=null) {
    		$filters['is_active'] = 1;
            try
            {
		        $collection = Mage::getModel('sales/quote')->getCollection();//->addAttributeToSelect('*');
            }
            catch (Mage_Core_Exception $e)
            {
               $this->_fault('cart_no_exists');
            }

            try {
                foreach ($filters as $field => $value) {
                    $collection->addFieldToFilter($field, $value);
                }
            } catch (Mage_Core_Exception $e) {
                $this->_fault('filters_invalid', $e->getMessage());
                // If we are adding filter on non-existent attribute
            }

            $result = array();
            foreach ($collection as $item) {
                $result[] = $item->getId();
            }

            return $result;
    }


    private function getCart($cartId){
        $cart = Mage::getModel('sales/quote')
                ->getCollection()
                ->addFieldToFilter("entity_id",$cartId)
                ->getFirstItem();
        $cart_item_arr = Mage::getModel('sales/quote_item')->getCollection()->setQuote($cart)->toArray();
        $i = 0;
        foreach($cart_item_arr['items'] as $v) {
            $cart_item_arr['items'][$i]['product_options'] = '';
            $cart_item_arr['items'][$i]['qty_ordered'] = $cart_item_arr['items'][$i]['qty'];
            $i++;
        }
        $cart_arr =$cart->toArray();
        $website_id = Mage::getModel('core/store')->load($cart_arr['store_id'])->getWebsiteId();
        $cart_arr['website_id'] = $website_id;
        $cart_arr['items'] = $cart_item_arr['items'];
        return $cart_arr;
    }


    private function prepareCustomerOrder($customerId, array $shoppingCart, array  $shippingAddress, array $billingAddress, 
        $shippingMethod, $couponCode = null) 
    {
        $customerObj = Mage::getModel('customer/customer')->load($customerId);
        $storeId = $customerObj->getStoreId();
        $quoteObj = Mage::getModel('sales/quote')->assignCustomer($customerObj);
        $storeObj = $quoteObj->getStore()->load($storeId);
        $quoteObj->setStore($storeObj);

        // add products to quote
        foreach($shoppingCart as $part) {
            $productModel = Mage::getModel('catalog/product');
            $productObj = $productModel->setStore($storeId)->setStoreId($storeId)->load($part['PartId']);

            $productObj->setSkipCheckRequiredOption(true);

            try{
                $quoteItem = $quoteObj->addProduct($productObj);
                $quoteItem->setPrice(20);
                $quoteItem->setQty(3);
                $quoteItem->setQuote($quoteObj);                                    
                $quoteObj->addItem($quoteItem);

            } catch (exception $e) {
            return false;
            }

            $productObj->unsSkipCheckRequiredOption();
            $quoteItem->checkData();
        }

        // addresses
        $quoteShippingAddress = new Mage_Sales_Model_Quote_Address();
        $quoteShippingAddress->setData($shippingAddress);
        $quoteBillingAddress = new Mage_Sales_Model_Quote_Address();
        $quoteBillingAddress->setData($billingAddress);
        $quoteObj->setShippingAddress($quoteShippingAddress);
        $quoteObj->setBillingAddress($quoteBillingAddress);

        // coupon code
        if(!empty($couponCode)) $quoteObj->setCouponCode($couponCode); 


        // shipping method an collect
        $quoteObj->getShippingAddress()->setShippingMethod($shippingMethod);
        $quoteObj->getShippingAddress()->setCollectShippingRates(true);
        $quoteObj->getShippingAddress()->collectShippingRates();
        $quoteObj->collectTotals(); // calls $address->collectTotals();
        $quoteObj->setIsActive(0);
        $quoteObj->save();

        return $quoteObj->getId();

    }
}
?>