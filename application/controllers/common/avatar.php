<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avatar extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}
	
    public function index($uid,$size)
    {
    	$avatar_url = get_avatar_url($uid, $size);
		redirect($avatar_url, 'location');
    }
}