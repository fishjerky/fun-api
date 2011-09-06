<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Auth
{
	private $_uid;
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('fun');
		@list($password, $this->_uid) = explode("\t", authcode($_COOKIE["uchome_auth"], 'DECODE'));
	} 

    public function is_logged_in()
    {
    	if ($this->_uid)
    		return true;
    	else
    		return false;
    }
    
    public function check_logged_in()
    {
    	if (!$this->_uid)
    		$this->log_in();
    }
    
    public function get_uid(){
        return $this->_uid;
    }
}
