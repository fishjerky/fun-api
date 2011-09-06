<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class Friends extends REST_Controller { 
	function __construct()
	{
		parent::__construct();

	}
	
	//��o�B�ͲM��
	function default_get()
	{  
		$this->load->model('Friends_model');
		$params = $this->validate_params(array('uid'=>TRUE,'count'=>FALSE,'start'=>FALSE));
	   	

		//�ˬd�Ѽ�
   		if(!$params)
   		{
   			$this->response('Invalid params', 404);
   		}

	   	if(intval($params['start'])>=0 && intval($params['count'])>=1)
   		{
   			$friends = $this->Friends_model->get_friends_by_uid($params['uid'],$params['count'],$params['start']);
   		}
   		else
   		{
   			$friends = $this->Friends_model->get_friends_by_uid($params['uid']);
   		}
   		
   		//�^�ǵ��G

		$this->response($friends, 200);
	}
	
	//��o�P�˵�U�����ε{�����B�ͲM��
	function app_get()
	{  
		$this->load->model('Friends_model');
		$params = $this->validate_params(array('uid'=>TRUE,'status'=>TRUE));
		
		//�ˬd�Ѽ�
   		if(!$params)
   		{
   			$this->response('Invalid params', 404);
   		}
		

   		//�^�ǵ��G
		$friend = $this->Friends_model->get_app_friends($params['uid'],$this->appid);
		$this->response($friend, 200); 
	}
}