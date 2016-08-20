<?php
class ElicoCorp_OpenERPConnector_Model_Wishlist_Api extends Mage_Checkout_Model_Api_Resource
{

    public function update($wishlistId, $data, $store = null) {
        $wishlist_obj = Mage::getModel('wishlist/wishlist')->load($id);
        $wishlist_products = $data['items'];

        if(count($wishlist_products) == 0) {
            return array();
        }

        $id = $data['customer_id'];
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

        $wishlist = Mage::getModel('wishlist/wishlist')->load($wishlistId);

        $wishlistItemCollection = $wishlist->getItemCollection();

        $products = array();
        foreach ($wishlistItemCollection as $item)
        {
            $id = $item->getProductId();
            if(array_key_exists($id, $wishlist_products)) {
                $qty = $wishlist_products[$item->getProductId()];
                $qty_left = $item->getQty() - $qty;
                if($qty_left > 0) {
                    $wishlist->updateItem($item->getWishlistItemId(),array('qty' => $qty_left));
                } elseif($qty_left == 0) {
                    $item->delete();
                } else {
                    continue;
                }
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
    
    public function info($wishlistIds) {
        $result = array();
        if(is_array($wishlistIds)) {
            foreach($wishlistIds as $wishlistId) {
                try {
                    $result[] = $this->get_wishlist($wishlistId);
                }
                catch (Mage_Core_Exception $e) {
                    $this->_fault('wishlist_not_exists');
                }
            }
            return $result;
        }
        elseif(is_numeric($wishlistIds)) {
            try {

                return $this->get_wishlist($wishlistIds);

            }
            catch (Mage_Core_Exception $e) {
                $this->_fault('wishlist_not_exists');
            }
        }
        return array();
    }

    public function search($filters = array(),$store_view=null) {
            try
            {
                $collection = Mage::getModel('wishlist/wishlist')->getCollection();
            }
            catch (Mage_Core_Exception $e)
            {
               $this->_fault('wishlist_no_exists');
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

    private function get_wishlist($id) {
        $wishlist_obj = Mage::getModel('wishlist/wishlist')->load($id);
        $wishlist = $wishlist_obj->toArray();
        $items =  $wishlist_obj->getItemCollection()->toArray();
        $customer_obj = Mage::getModel('customer/customer')->load($wishlist['customer_id']);
        $website_obj = Mage::getModel('core/website')->load($customer_obj->getWebsiteId());
        $wishlist['store_id'] = $website_obj->getDefaultGroup()->getDefaultStoreId();
        $wishlist['website_id'] = $customer_obj->getStore()->getWebsite()->getId();
        $wishlist['created_at'] = date("Y-m-d H:i:s");            

        foreach($items['items'] as $k => $v) {
            $items['items'][$k]['base_row_total'] = $v['price'] * $v['qty'];
            $items['items'][$k]['base_row_total_incl_tax'] = $v['price'] * $v['qty'];
            $items['items'][$k]['qty_ordered'] = $v['qty'];
            $items['items'][$k]['product_options'] = '';
        }
        $wishlist['items'] = $items['items'];
        return $wishlist;
    }
}
?>
