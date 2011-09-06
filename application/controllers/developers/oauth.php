<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('developers');
	}
	
	public function index()
	{
		$this->template->build('developers/index');
	}
}