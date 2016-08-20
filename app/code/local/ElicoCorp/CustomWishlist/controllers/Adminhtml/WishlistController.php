<?php
class ElicoCorp_CustomWishlist_Adminhtml_WishlistController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
	
		//         $this->loadLayout();
		// $test = $this->test();
		//         //create a text block with the name of "example-block"
		//         $block = $this->getLayout()
		//         ->createBlock('core/text', 'example-block')
		//         ->setText('<pre>'.print_r($test).'</pre>');
		// 
		//         $this->_addContent($block);
		// 
		//         $this->renderLayout();
		$this->loadLayout();
		$this->_title($this->__("Index"));
	    $this->renderLayout();
    }
}
?>