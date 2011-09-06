<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiv1 extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('developers');
	}
	
	//會員資料
    public function user()
    {
		$this->template->build('developers/apiv1/user');
    }
    
    //朋友
    public function friends()
    {
		$this->template->build('developers/apiv1/friends');
    }
    
    //塗鴉牆
    public function feeds()
    {
		$this->template->build('developers/apiv1/feeds');
    }
    
    //相本
    public function albums()
    {
		$this->template->build('developers/apiv1/albums');
    }
    
    //粉絲團
    public function fans()
    {
		$this->template->build('developers/apiv1/fans');
    }
}