<?php
class Apps_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 新增應用程式
     * @access	public
	 * @param	int		$uid			使用者編號
	 * @param	string	$appname		應用程式名稱
	 * @param	string	$description	應用程式說明
	 * @param	string	$siteurl		網站位址
	 * @param	string	$thumb			應用程式縮圖
	 * @param	string	$redirect_uri	網址
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
     * 更新應用程式
     * @access	public
     * @param	int		$appid			應用程式編號
	 * @param	string	$appname		應用程式名稱
	 * @param	string	$description	應用程式說明
	 * @param	string	$siteurl		網站位址
	 * @param	string	$thumb			應用程式縮圖
	 * @param	string	$redirect_uri	網址
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
     * 刪除應用程式
     * @access	public
     * @param	int		$appid			應用程式編號
     * @return	void
     */
    public function delete_app($appid){
    	$this->db->where('appid', $appid)->delete("uchome_app");
    }
    
	/**
     * 我的應用程式
     * @access	public
     * @param	int		$uid			使用者編號
     * @param	int		$appid			應用程式編號
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
     * 取得亂數唯一值
     * @access	private
     * @param	bool	$unique			不重覆
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