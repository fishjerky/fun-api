<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class User extends REST_Controller { 
	function __construct()
	{
		parent::__construct();
	}
	
	//使用者基本資料
	function default_get()
	{  
		$this->load->model('User_model');
	   	$params = $this->validate_params(array('uid'=>TRUE));

   		//檢查參數
   		if(!$params)
   		{
   			$this->response('Invalid params', 404);
   		}
   		
   		//回傳結果
		$result = $this->User_model->get_user_by_uid($params['uid']);
		$this->response($result, 200);
	}
}