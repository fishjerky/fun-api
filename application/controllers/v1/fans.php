<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class Fans extends REST_Controller { 
	function __construct()
	{
		parent::__construct();
	}
	
	//粉絲團清單
	function default_get()
	{  
		$this->load->model('Fans_model');
		
		//接收參數
		$uid = $this->get('uid');
		$fanid = $this->get('fanid');

		$fan = $this->Fans_model->get_fans_by_uid($uid,$fanid);
		if($fan)  
			$this->response($fan, 200); 
		else  
			$this->response('Invalid params', 404);
	}
}