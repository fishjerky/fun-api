<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avatar extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('developers');
	}
	
	//ÀY¹³
    public function index()
    {
		$this->template->build('developers/avatar/avatar');
    }
}