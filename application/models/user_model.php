<?php
class User_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 取得User基本資料
     * @access	public
	 * @param	int		$uid	使用者編號
     * @return	array			使用者資料
     */
    public function get_user_by_uid($uid)
    {
    	$this->db->select('op.logintype ,op.uid, op.username,op.opid, op.pid,us.sex,us.email, us.birthprovince, us.birthcity, us.resideprovince, us.residecity')
    	->from('openid op')
    	->join('uchome_spacefield us', 'op.uid = us.uid')
    	->where('op.uid', $uid);
    	
    	$data = $this->db->get()->row_array();
    	//姓別
    	if($data['sex']=="1")
    		$data['sex'] = "male";
    	else if($data['sex']=="2")
    		$data['sex'] = "female";
    	else
		    $data['sex'] = "";
    	return $data;
    }
}