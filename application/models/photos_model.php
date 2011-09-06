<?php
class Photos_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * �s�W�ۤ�
     * @access public
	 * @param array $data	�ۤ���T
     * @return array		�ۤ��s��
     */	
    public function add_photo($photo)
    {
    	$this->db->insert('uchome_pic', $photo);
    	return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }
    
	/**
     * ���o�ۤ�
     * @access	public
	 * @param	int		$alubmid	��ï�s��
     * @return	array				�ۤ��M��
     */	
    public function get_photos_by_albumid($albumid)
    {
    	$this->db->select('albumid ,albumname, uid, username, picnum, updatetime')->get_where('uchome_pic', array('albumid' => $albumid,'flag'=>0));
        return $this->db->get()->result_array();
    }
}