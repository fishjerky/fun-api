<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class Invites  extends REST_Controller { 
	
	private $settings;
	private $user;
	function __construct()
	{
		parent::__construct();
		//取得邀請設定
		$this->settings = array(
			'appId' => $this->input->get_post("appId"),
			'access_token' => $this->input->get_post("access_token"),
			'title'=> $this->input->get_post("title"),
			'content'=> $this->input->get_post("content"),
			'accept_url'=> $this->input->get_post("accept_url")
		);
	}
	
    public function default_get()
    {
	    $this->load->model('Friends_model');
	    $max = $this->input->get_post("max");
	    $action_url = $this->input->get_post("action_url");
	    
	    //設定
	    $data['settings'] = $this->settings;
	    $data['settings']['max'] = $max;
	    $data['settings']['action_url'] = $action_url;
	    
	    //群組
	    $data['group'] = $this->Friends_model->get_groups($this->uid);
	    	
	    //朋友清單
	    $data['friends'] = $this->Friends_model->get_friends_by_uid($this->uid);
	    
		$this->load->view('common/invites',$data);
    }
    
    public function default_post()
    {
    	$this->load->model('Apps_model');
    	$this->load->model('Invites_model');
    	$touids = $this->input->post("touids");
	    $appinfo = $this->Apps_model->get_my_apps($this->uid,$this->appid);
	    $invite = array();
	    $invite['uid'] = $this->uid;
	    $invite['username'] = $this->username;
	    $invite['touids'] = $touids;
	    $invite['appid'] = $appinfo['appid'];
	    $invite['appname'] = $appinfo['appname'];
	    $invite['title'] = $this->settings["title"];
		$invite['content'] = $this->settings["content"];
		$invite['accept_url'] = $this->settings["accept_url"];
		$invite['hash'] = md5($invite['appid'].$invite['title'].$invite['content'].$invite['accept_url']);
		//$this->Invites_model->create_invite($invite);
		echo "ok";
        exit();
    } 
}