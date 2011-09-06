<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class User extends REST_Controller { 
	function __construct()
	{
		parent::__construct();
	}
	
	//�ϥΪ̰򥻸��
	function default_get()
	{  
		$this->load->model('User_model');
	   	$params = $this->validate_params(array('uid'=>TRUE));

   		//�ˬd�Ѽ�
   		if(!$params)
   		{
   			$this->response('Invalid params', 404);
   		}
   		
   		//�^�ǵ��G
		$result = $this->User_model->get_user_by_uid($params['uid']);
		$this->response($result, 200);
	}
}