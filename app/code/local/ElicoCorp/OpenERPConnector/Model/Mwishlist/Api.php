<?php
class ElicoCorp_OpenERPConnector_Model_Mwishlist_Api extends Mage_Checkout_Model_Api_Resource
{

    public function update($wishlistId, $data, $store = null) {
        $wishlist_obj =  Mage::getModel('itoris_mwishlist/wishlist')->getById($wishlistId);
        $wishlist_products = $data['items'];
        #if(count($wishlist_products) == 0) {
        #    return array();
        #}

        $id = $wishlist_obj[0]['customer_id'];
        $customer = Mage::getModel('customer/customer')->load($id);

        $transaction = Mage::getModel('core/resource_transaction');

        $storeId = $customer->getStoreId();
        $reservedOrderId = Mage::getSingleton('eav/config')->getEntityType('order')->fetchNewIncrementId($storeId);

        $order = Mage::getModel('sales/order')
        ->setIncrementId($reservedOrderId)
        ->setStoreId($storeId)
        ->setQuoteId(0);


        $order->setCustomer_email($customer->getEmail())
            ->setCustomerFirstname($customer->getFirstname())
            ->setCustomerLastname($customer->getLastname())
            ->setCustomerGroupId($customer->getGroupId())
            ->setCustomer_is_guest(0)
            ->setCustomer($customer);

        $billing = $customer->getDefaultBillingAddress();
        $billingAddress = Mage::getModel('sales/order_address')
            ->setStoreId($storeId)
            ->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
            ->setCustomerId($customer->getId())
            ->setCustomerAddressId($customer->getDefaultBilling())
            ->setCustomer_address_id($billing->getEntityId())
            ->setPrefix($billing->getPrefix())
            ->setFirstname($billing->getFirstname())
            ->setMiddlename($billing->getMiddlename())
            ->setLastname($billing->getLastname())
            ->setSuffix($billing->getSuffix())
            ->setCompany($billing->getCompany())
            ->setStreet($billing->getStreet())
            ->setCity($billing->getCity())
            ->setCountry_id($billing->getCountryId())
            ->setRegion($billing->getRegion())
            ->setRegion_id($billing->getRegionId())
            ->setPostcode($billing->getPostcode())
            ->setTelephone($billing->getTelephone())
            ->setFax($billing->getFax());
        $order->setBillingAddress($billingAddress);

        $shipping = $customer->getDefaultShippingAddress();
        $shippingAddress = Mage::getModel('sales/order_address')
            ->setStoreId($storeId)
            ->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING)
            ->setCustomerId($customer->getId())
            ->setCustomerAddressId($customer->getDefaultShipping())
            ->setCustomer_address_id($shipping->getEntityId())
            ->setPrefix($shipping->getPrefix())
            ->setFirstname($shipping->getFirstname())
            ->setMiddlename($shipping->getMiddlename())
            ->setLastname($shipping->getLastname())
            ->setSuffix($shipping->getSuffix())
            ->setCompany($shipping->getCompany())
            ->setStreet($shipping->getStreet())
            ->setCity($shipping->getCity())
            ->setCountry_id($shipping->getCountryId())
            ->setRegion($shipping->getRegion())
            ->setRegion_id($shipping->getRegionId())
            ->setPostcode($shipping->getPostcode())
            ->setTelephone($shipping->getTelephone())
            ->setFax($shipping->getFax());
        $order->setShippingAddress($shippingAddress);
        $order->getShippingAddress()->setShippingMethod('freeshipping_freeshipping');

        $orderPayment = Mage::getModel('sales/order_payment')
            ->setStoreId($storeId)
            ->setCustomerPaymentId(0)
            ->setMethod('banktransfer')
            ->setPo_number(' – ');
        $order->setPayment($orderPayment);

        $subTotal = 0;

        $wishlist = Mage::getModel('itoris_mwishlist/wishlist')->getById($wishlistId);

        $wishlistItemCollection = Mage::getModel('itoris_mwishlist/wishlist')->getWishlistItems($wishlistId);
        $products = array();
        foreach ($wishlistItemCollection as $item)
        {
            $id = $item['product_id'];
            $item_obj = Mage::getModel('wishlist/item')->load($item['id']);
            if(!$item_obj->getId()) { 
		continue;
	    }
            if(array_key_exists($id, $wishlist_products)) {
                $qty = $wishlist_products[$id];
                $item_obj->setQty($qty); 
                $item_obj->save();
                $products[$id] = array('qty' => $item['qty'] - $qty);
            } else {
                $qty = $item_obj->getQty();
                $item_obj->delete();
                $products[$id] = array('qty' => $qty);
            }
 	}

        foreach ($products as $productId => $product) {
            $_product = Mage::getModel('catalog/product')->load($productId);
            if($product['qty'] == 0)
                continue;
            $rowTotal = $_product->getPrice() * $product['qty'];
            $orderItem = Mage::getModel('sales/order_item')
                ->setStoreId($storeId)
                ->setQuoteItemId(0)
                ->setQuoteParentItemId(NULL)
                ->setProductId($productId)
                ->setProductType($_product->getTypeId())
                ->setQtyBackordered(NULL)
                ->setTotalQtyOrdered($product['rqty'])
                ->setQtyOrdered($product['qty'])
                ->setName($_product->getName())
                ->setSku($_product->getSku())
                ->setPrice($_product->getPrice())
                ->setBasePrice($_product->getPrice())
                ->setOriginalPrice($_product->getPrice())
                ->setRowTotal($rowTotal)
                ->setBaseRowTotal($rowTotal);

        $subTotal += $rowTotal;
            $order->addItem($orderItem);
        }

        $order->setSubtotal($subTotal)
            ->setBaseSubtotal($subTotal)
            ->setGrandTotal($subTotal)
            ->setBaseGrandTotal($subTotal);

        $transaction->addObject($order);
        $transaction->addCommitCallback(array($order, 'place'));
        $transaction->addCommitCallback(array($order, 'save'));
        $transaction->save();
        return array('order_id', $order->getId());
    }
    
    public function info($id) {
        $res = Mage::getModel('itoris_mwishlist/wishlist')->getById($id);
        if(count($res) == 0) {
            return $res;
        }
        $wishlist = array(
            'store_id' => (int) $res[0]['store_id'],
            'wishlist_id' => (int) $res[0]['wishlist_id'],
            'id' => (int) $res[0]['wishlist_id'],
            'wishlist' => (int) $res[0]['multiwishlist_is_main'],
            'customer_id' => (int) $res[0]['customer_id'],
            'date_order' => $res[0]['date_order'],
            'items' => array());
        if(isset($res[0]['product_id'])) {
            $wishlist['items'] = $res;
        }
        return $wishlist;
    }

    public function search($filters=null,$store_view=null) {
         $reservation = False;
         if(is_array($filters) && isset($filters['reservation'])) {
            $reservation = $filters['reservation'];
         }
         $customers = Mage::getModel('customer/customer')->getCollection();
         $wishlists = array();
         $wishlist_obj = Mage::getModel('itoris_mwishlist/wishlist');
         return $wishlist_obj->getAllIds($reservation);
    }
}
?>
