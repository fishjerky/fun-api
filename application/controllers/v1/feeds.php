<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class Feeds extends REST_Controller { 
	function __construct()
	{
		parent::__construct();
	}
	
	//�s�W��~����
	function default_post()
	{  
		$this->load->model('Feeds_model');
		
    	//���������Ѽ�
		$params = $this->validate_params(array('title'=>TRUE,'subject'=>TRUE,'summary'=>TRUE,'image'=>TRUE,'link'=>TRUE,'general'=>TRUE));

		//�ˬd�Ѽ�
   		if(!$params)
   		{
   			$this->response('Invalid params', 404);
   		}
		
		$feed = array();
    	$feed['title'] = $params['title'];
    	$feed['subject'] = $params['subject'];
    	$feed['summary'] = $params['summary'];
		$feed['image'] = $params['image'];
		$feed['link'] = $params['link'];
    	$feed['general'] = $params['general'];
    	$feed['appid'] = $this->appid;
    	$feed['icon'] = 'userapp';
    	$feed['uid'] = $this->uid;
    	$feed['username'] = $this->username;

    	//�g�J��Ʈw
    	$feedid = $this->Feeds_model->create_feed($feed);
    	$result['feedid'] = $feedid;
		$this->response($result, 200); 
	}
}