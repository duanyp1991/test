<?php
class ELicoCorp_OpenERP_IndexController extends Mage_Core_Controller_Front_Action {        

    public function indexAction() {
    	Mage::log('log info');
        echo 'Hello Index!';

    }
    public function cartconfirmAction() {
	    $this->loadLayout();
	    $this->renderLayout();
	}
	public function goodbyeAction() {
	    echo 'Goodbye World!';
	    Mage::log('GoodBye');
	}
	public function paramsAction() {
	    echo '<dl>';            
	    foreach($this->getRequest()->getParams() as $key=>$value) {
	        echo '<dt><strong>Param: </strong>'.$key.'</dt>';
	        echo '<dt><strong>Value: </strong>'.$value.'</dt>';
	    }
	    echo '</dl>';
	}
}