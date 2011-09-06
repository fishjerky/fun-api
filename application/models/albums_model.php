<?php
class Albums_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 取得相簿清單
     * @access	public
	 * @param	int		$uid	使用者編號
     * @return	array
     */
    public function get_albums_by_uid($uid)
    {
    	$this->db->select('albumid , albumname, picnum, updatetime')->from('uchome_album')->where('uid', $uid)->where('flag', 0);
        return $this->db->get()->result_array();
    }
    
	/**
     * 取得照片清單
     * @access	public
	 * @param	int		$albumid	相簿編號
     * @return	array
     */
    public function get_albums_by_alubmid($albumid)
    {
    	$this->db->select('picid , title, filepath')->get_where('uchome_pic', array('albumid' => $albumid,'flag'=>0));
        return $this->db->get()->result_array();
    }
}