<?php
class Fans_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * ���o�ϥΪ̥[�J��������
     * @access	public
	 * @param	int		$uid	�ϥΪ̽s��
	 * @param	int		$fanid	�����νs��
     * @return	array
     */
    public function get_fans_by_uid($uid, $fanid = 0)
    {
    	$this->db->select('f.fanid,f.fanname')
    	->from('uchome_fan f')
    	->join('uchome_fanspace uf', 'f.fanid = uf.fanid')
    	->where('uf.uid', $uid);
    	if($fanid)
    	{
    		$this->db->where('f.fanid', $fanid);
    		return $this->db->get()->row_array();
    	}
    	else
    	{
			return $this->db->get()->result_array();
    	}
    }
}