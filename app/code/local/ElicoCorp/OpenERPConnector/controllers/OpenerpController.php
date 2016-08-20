<?php
require_once("lib/xpot.php");
require_once('lib/xmlrpclib/xmlrpc.inc');

ini_set("display_errors",1);

class ELicoCorp_OpenERP_OpenerpController extends Mage_Core_Controller_Front_Action {
	protected function _getOpenERPConfig(){
		$ini_array = parse_ini_file("config.ini", true);
		//only get section openerp
		return $ini_array['openerp'];
	}

	protected function _prepareMessags($config,$params){

		//messages
		$msg = new xmlrpcmsg('execute');
		$msg->addParam(new xmlrpcval($config['db'], "string"));//db name
		$msg->addParam(new xmlrpcval("1", "int"));//openerp uid
		$msg->addParam(new xmlrpcval($config['password'], "string") );//password of openerp uid
		$msg->addParam(new xmlrpcval($params['object'], "string"));//model name, fixed
		$msg->addParam(new xmlrpcval($params['method'], "string"));//method name, fixed
		//params put it in array add foreach
		$msg->addParam(new xmlrpcval(1,"int"));//ids, fixed

		return $msg;
	}
	protected function getconfigAction(){
		// Parse with sections
		$ini_array = $this->_getOpenERPConfig();
		xpot($ini_array);

	}

    public function indexAction() {
    	Mage::log('log info');
        echo 'Hello OpenERP Connector!';

    }
	public function callAction() {
		/*XML-RPC to OpenERP -- start, LIN Yu, 20130715*/
		$timestamp = time() + 8*60*60;
		// echo date("Y-m-d H:i:s",$timestamp);

		$config = $this->_getOpenERPConfig();
		$params = $this->getRequest()->getParams();
		// $params = $this->getRequest()->getPost();
		Mage::log("openerp ".$params['object'].' :'.$params['method'].' START');
		#TODO check object, method, params

		//client
		$client = new xmlrpc_client("http://".$config['host'].":".$config['port']."/xmlrpc/object");

		//messages
		$msg = $this->_prepareMessags($config, $params);
		
		$resp = $client->send($msg);
		//xpot($msg);

		$array = 0;
		if ($resp->faultCode()){
		        echo 'Error: '.$resp->faultString();
		}
		else{
				$array = php_xmlrpc_decode($resp->value());//$resp->value();

		        echo 'Success['.$array.']';
				xpot($array);
		}
		//echo "openerp ".$params['object'].' :'.$params['method'].' END';
		Mage::log("openerp ".$params['object'].'-'.$params['method'].': '.$array.' END');
		return $array;
		/*XML-RPC to OpenERP -- end*/
	}

}