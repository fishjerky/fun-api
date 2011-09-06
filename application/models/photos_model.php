<?php
class Photos_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 新增相片
     * @access public
	 * @param array $data	相片資訊
     * @return array		相片編號
     */	
    public function add_photo($photo)
    {
    	$this->db->insert('uchome_pic', $photo);
    	return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }
    
	/**
     * 取得相片
     * @access	public
	 * @param	int		$alubmid	相簿編號
     * @return	array				相片清單
     */	
    public function get_photos_by_albumid($albumid)
    {
    	$this->db->select('albumid ,albumname, uid, username, picnum, updatetime')->get_where('uchome_pic', array('albumid' => $albumid,'flag'=>0));
        return $this->db->get()->result_array();
    }
}