<?php
class Invites_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 新增邀請
     * @access	public
	 * @param	array		$invite	邀請資料
     * @return	void
     */
    public function create_invite($invite)
    {
    	$this->db->select('touid')->get_where('uchome_appinvite', array('uid' => $invite['uid'],'hash'=>$invite['hash']));
	    
    	//找出邀請過的朋友
	    $haves = array();
	    foreach($this->db->get()->result_array() as $key=>$value){
	    	$haves[$value['touid']] = $value['touid'];
	    }

	    //去除邀請過的朋友
	    $inserts = $touids = array();
	    $nones = array_diff($invite['touids'], $haves);
	    foreach ($nones as $uid) {
			$touids[] = $uid;
			$inserts[] = array('uid'=>$invite[uid],
								'username'=>$invite[username],
								'appid'=>$invite[appid],
								'appname'=>$invite[appname],
								'title'=>$invite[title],
								'content'=>$invite[content],
								'accepturl'=>$invite[accept_url],
								'hash'=>$invite[hash],
								'dateline'=>time(),
								'status'=>1);
	    }
	    
		//新增邀請資料
    	if($inserts) {    		
    		$this->db->query("UPDATE uchome_space SET appinvitenum=appinvitenum+1 WHERE uid IN (".implode(",",$touids).")");
    		$this->db->insert_batch('uchome_appinvite', $inserts); 
    	}
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}