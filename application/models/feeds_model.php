<?php
class Feeds_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	/**
     * 新增塗鴉牆資料
     * @access	public
	 * @param	array		$data	塗鴉牆資料
     * @return	int					塗鴉牆編號
     */
    public function create_feed($data)
    {
		$title_template = "{actor} ".$data['title'];
		$title_data = "N;";
		$body_template="<b>{subject}</b><br>{summary}";
		$body_data=array(
			'subject' => '<a href="'.$data['link'].'">'.$data['subject']."</a>",
			'summary' => $data['summary']
		);
		
		$new_feed = array(
			'appid' => $data['appid'],
			'icon' => $data['icon'],
			'uid' => $data['uid'],
			'username' => $data['username'],
			'dateline' => time(),
			'lastdateline' => time(),
			'title_template' => $title_template,
			'body_template' => $body_template,
			'body_general' => $data['general'],
			'image_1' => $data['image'],
			'image_1_link' => $data['link'],
			'fanname'=>'',
			'target_ids'=>''
		);
		
		$new_feed = $this->sstripslashes($new_feed);//去掉轉義
		$new_feed['title_data'] = serialize($this->sstripslashes($title_data));//陣列轉化
		$new_feed['body_data'] = serialize($this->sstripslashes($body_data));//陣列轉化
		$new_feed['hash_template'] = md5($new_feed['title_template']."\t".$new_feed['body_template']);//喜好hash
		$new_feed['hash_data'] = md5($new_feed['title_template']."\t".$new_feed['title_data']."\t".$new_feed['body_template']."\t".$new_feed['body_data']);//合併hash
        
		$this->db->insert('uchome_feed', $new_feed);
    	return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
    }
    
    
	//去掉slassh
	private function sstripslashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = $this->sstripslashes($val);
			}
		} else {
			$string = stripslashes($string);
		}
		return $string;
	}
	
	//SQL ADDSLASHES
	function saddslashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = $this->saddslashes($val);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}
}