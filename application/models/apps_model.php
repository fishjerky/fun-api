<?php
class Apps_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * �s�W���ε{��
     * @access	public
	 * @param	int		$uid			�ϥΪ̽s��
	 * @param	string	$appname		���ε{���W��
	 * @param	string	$description	���ε{������
	 * @param	string	$siteurl		������}
	 * @param	string	$thumb			���ε{���Y��
	 * @param	string	$redirect_uri	���}
     * @return	array
     */
    public function insert_app($uid,$appname,$description,$siteurl,$thumb,$redirect_uri)
    {
	    $app = array(
	    	'uid' => $uid,
	    	'classid' => 0,
			'appname' => $appname,
			'description' => $description,
	    	'siteurl' => $siteurl,
			'manufacturers' => "user",
			'thumb' => $thumb,
	    	'client_secret' => $this->generate_key(true),
	        'redirect_uri' => $redirect_uri,
	    	'auto_approve' => 1,
			'dateline' => time()
		);
		$this->db->insert('uchome_app', $app);
    }
    
	/**
     * ��s���ε{��
     * @access	public
     * @param	int		$appid			���ε{���s��
	 * @param	string	$appname		���ε{���W��
	 * @param	string	$description	���ε{������
	 * @param	string	$siteurl		������}
	 * @param	string	$thumb			���ε{���Y��
	 * @param	string	$redirect_uri	���}
     * @return	void
     */
    public function update_app($appid,$appname,$description,$siteurl,$thumb,$redirect_uri)
    {
	    $app = array(
			'appname' => $appname,
			'description' => $description,
	    	'siteurl' => $siteurl,
			'thumb' => $thumb,
	        'redirect_uri' => $redirect_uri,
			'dateline' => time()
		);
		$this->db->where('appid', $appid)->update('uchome_app', $app);
    }
    
	/**
     * �R�����ε{��
     * @access	public
     * @param	int		$appid			���ε{���s��
     * @return	void
     */
    public function delete_app($appid){
    	$this->db->where('appid', $appid)->delete("uchome_app");
    }
    
	/**
     * �ڪ����ε{��
     * @access	public
     * @param	int		$uid			�ϥΪ̽s��
     * @param	int		$appid			���ε{���s��
     * @return	void
     */
    public function get_my_apps($uid,$appid = 0){
		$this->db->select('*')->from('uchome_app')->where('uid', $uid);
    	if($appid){
    		$this->db->where('appid', $appid);
    		return $this->db->get()->row_array();
    	}else
    		return $this->db->get()->result_array();
    }
    
	/**
     * ���o�üưߤ@��
     * @access	private
     * @param	bool	$unique			������
     * @return	void
     */
	private function generate_key ( $unique = false )
	{
		$key = md5(uniqid(rand(), true));
		if ($unique)
		{
			list($usec,$sec) = explode(' ',microtime());
			$key .= dechex($usec).dechex($sec);
		}
		return $key;
	}
}