<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class Feeds extends REST_Controller { 
	function __construct()
	{
		parent::__construct();
	}
	
	//新增塗鴉牆資料
	function default_post()
	{  
		$this->load->model('Feeds_model');
		
    	//接收相關參數
		$params = $this->validate_params(array('title'=>TRUE,'subject'=>TRUE,'summary'=>TRUE,'image'=>TRUE,'link'=>TRUE,'general'=>TRUE));

		//檢查參數
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

    	//寫入資料庫
    	$feedid = $this->Feeds_model->create_feed($feed);
    	$result['feedid'] = $feedid;
		$this->response($result, 200); 
	}
}