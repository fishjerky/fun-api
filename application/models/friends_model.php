<?php
class Friends_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * ��o�ϥΪ̦n�ͲM��
     * @access	public
	 * @param	int			$uid	�ϥΪ̽s��
     * @return	array				�n�ͲM��
     */
    public function get_friends_by_uid($uid,$count,$start)
    {   	
    	//$this->db->select('fuid as uid, fusername as username ,gid')->from('uchome_friend')->where('uid', $uid)->where('status', 1);
    	$this->db->select('fuid as uid,fusername as username,us.sex,gid')->from('uchome_friend uf')->join('uchome_spacefield us', 'uf.fuid=us.uid')->where('uf.uid', $uid)->where('uf.status', 1);
    	if($count)
    	{
    		$this->db->limit($count, $start);
    	}
    	
    	$result = $this->db->get()->result_array();
        foreach($result as $key=>$value){
        	$value['avatar_small'] = "http://bbs.wayi.com.tw/ucserver/avatar.php?uid=".$value['uid'];
	    	//�m�O
	        if($value['sex']=="1")
	        	$value['sex'] = "male";
		    else if($value['sex']=="2")
		    	$value['sex'] = "female";
		    else
		    	$value['sex'] = "";

        	$result[$key] = $value;
        }
        return $result;
    }
    
	/**
     * ��o�n�͸s��
     * @access	public
	 * @param	int			$uid	�ϥΪ̽s��
     * @return	array				�n�͸s��
     */
    public function get_groups($uid)
    {
    	$this->db->select('privacy')->from('uchome_spacefield')->where('uchome_spacefield.uid', $uid);
    	$result = $this->db->get()->row_array();
    	
    	$privacy = unserialize($result);
        $group= array();
        if(array_key_exists('groupname',$privacy))
        	$group = $privacy['groupname'];
        return $group;
    }
    
	/**
     * ��o�w�ˬۦP���ε{�����n��
     * @access	public
	 * @param	int			$uid	�ϥΪ̽s��
	 * @param	int			$appid	���ε{���s��
     * @return	array				�n��
     */
    public function get_app_friends($uid,$appid)
    {
    	$this->db->select('fuid as uid,fusername as username')->from('uchome_friend uf')->join('uchome_userapp uu', 'uf.fuid=uu.uid')->where('uf.uid', $uid)->where('uu.appid', $appid);
		
    	$result = $this->db->get()->result_array();
        return $result;
    }
}