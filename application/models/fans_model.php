<?php
class Fans_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 取得使用者加入的粉絲團
     * @access	public
	 * @param	int		$uid	使用者編號
	 * @param	int		$fanid	粉絲團編號
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