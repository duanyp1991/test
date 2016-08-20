<?php  

class ElicoCorp_CustomWishlist_Block_Adminhtml_Wishlist extends Mage_Adminhtml_Block_Template {
	
	 /**
	 * Return a custom product array
	 *
	 * @return Array
	 * @author Augustin Cisterne-Kaas
	 **/
	public function getProducts() {
		# get  all the item in the wishlist
		$wishLists = Mage::getModel('wishlist/item')->getCollection();
		
		$products = array();
		
		foreach($wishLists as $item) {
			// if the product has been already insert on another client wishlist
			
			if(array_key_exists($item['product_id'],$products)) {
				//increase the product quantity
				$products[$item['product_id']]['qty'] += (int) $item['qty'];
				//increase the number of customer on that product
				$products[$item['product_id']]['nb_customers'] += 1;
				continue;
			}
			$products[$item['product_id']] = array(
					'name' => $item['name'],
					'qty'=> (int) $item['qty'],
					'nb_customers' => 1
				);
		}
		return $products;
	}
}
?>

<?php  

// class ElicoCorp_CustomWishlist_Block_Adminhtml_Wishlist extends Mage_Adminhtml_Block_Template {
// 	
// 	private $products;
// 	private $customers;
// 	 /**
// 	 * Return a custom product array
// 	 *
// 	 * @return Array
// 	 * @author Augustin Cisterne-Kaas
// 	 **/
// 	public function getProducts() {
// 		# get  all the item in the wishlist
// 		$wishLists = Mage::getModel('wishlist/item')->getCollection();
// 		
// 		$this->products = array();
// 		$this->customers = array();
// 		
// 		foreach($wishLists as $item) {
// 			// if the product has been already insert on another client wishlist
// 			$item['nb_customers'] = 1;
// 			echo $item['nb_customers'];
// 			$customer = Mage::getSingleton('customer/customer')->load($item['wishlist_id']);
// 
// 			$this->products[$item['product_id']] = [
// 					"name" => $item['name'],
// 					"qty"=> (int) $this->_get('qty',$item),
// 					"nb_customers" => $this->_get('nb_customers',$item),
// 					
// 				];
// 		}
// 		return $this->products;
// 	}
// 	
// 	private function _get($key,$item) {
// 		if(array_key_exists($item['product_id'],$this->products))
// 			return $this->products[$key] + $item[$key]; //increase the product quantity
// 		return $item[$key];
// 	}
// 
// }
?>
