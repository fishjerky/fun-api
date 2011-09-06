<?php
class Invites_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * �s�W�ܽ�
     * @access	public
	 * @param	array		$invite	�ܽи��
     * @return	void
     */
    public function create_invite($invite)
    {
    	$this->db->select('touid')->get_where('uchome_appinvite', array('uid' => $invite['uid'],'hash'=>$invite['hash']));
	    
    	//��X�ܽйL���B��
	    $haves = array();
	    foreach($this->db->get()->result_array() as $key=>$value){
	    	$haves[$value['touid']] = $value['touid'];
	    }

	    //�h���ܽйL���B��
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
	    
		//�s�W�ܽи��
    	if($inserts) {    		
    		$this->db->query("UPDATE uchome_space SET appinvitenum=appinvitenum+1 WHERE uid IN (".implode(",",$touids).")");
    		$this->db->insert_batch('uchome_appinvite', $inserts); 
    	}
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}