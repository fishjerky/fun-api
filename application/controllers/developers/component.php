<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Component extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('developers');
	}
    
    public function as3()
    {
		$this->template->build('developers/component/as3');
    }
    
    public function asp()
    {
		$this->template->build('developers/component/asp');
    }
    
    public function jqueryplugin()
    {
		$this->template->build('developers/component/jqueryplugin');
    }
    
    public function php()
    {
		$this->template->build('developers/component/php');
    }
}