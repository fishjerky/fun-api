<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 
class Albums extends REST_Controller { 
	function __construct()
	{
		parent::__construct();
	}
	
	//��o��ï�M��
	function default_get()
	{  
		$this->load->model('Albums_model');
		
		$uid = intval($this->get('uid'));
		$albumid = intval($this->get('albumid'));
		
    	if($albumid)
    	{
    		$data = $this->Photos_model->get_photos_by_albumid($albumid); //�Ӥ�M��
    	}
    	else
    	{
    		$data = $this->Albums_model->get_albums_by_uid($uid); //��ï�M��
    	}

		if($data)
			$this->response($data, 200); 
		else  
			$this->response(NULL, 404);
	}
	
   //�W�ǷӤ�
   public function default_post()
   {

   		$this->load->config('fun');
   		$params = $this->validate_params(array('albumid'=>TRUE,'title'=>TRUE));

   		//�ˬd�Ѽ�
   		if(!$params)
   		{
   			$this->response('Invalid params', 404);
   		}
   		

	    $file_name = $this->uid."_".$this->timestamp.$this->random(4).'.jpg';
	    $save_path = $this->config->item('attachdir').'/'.$this->get_file_path();

		//�W�ǹϤ�]�w
		$config['upload_path'] = $this->config->item('attachdir');
		//$config['allowed_types'] = 'jpg|jpeg|gif|png';
		$config['allowed_types'] = '*';
		$config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);

	    if($this->upload->do_upload("upload_file"))
	    {
	    	//��o�W���ɮ׸�T
	    	$file = $this->upload->data();
	    	
	    	//���s�R�W
	    	$old_path = $file['full_path'];
	    	$new_path = $save_path.'/'.$file_name;
	    	
	    	rename($old_path, $new_path);

	    	//�g�J��Ʈw
		    $photo = array();
		    $photo['albumid'] = 0;
		    $photo['uid'] = $this->uid;
		    $photo['username'] = $this->username;
		    $photo['dateline'] = $this->timestamp;
		    $photo['postip'] = $_SERVER['REMOTE_ADDR'];
		    $photo['filename'] = $file['full_path'];
		    $photo['title'] = $params['title'];
		    $photo['type'] = $file['file_type'];
		    $photo['size'] = $file['file_size'];
		    $photo['filepath'] = $this->get_file_path()."/".$file_name;
		    $photo['remote'] = 0;
		    $photo['topicid'] = 0;
		    $this->makethumb($new_path);
		    
		    $this->load->model('Photos_model');
		    $pid = $this->Photos_model->add_photo($photo);
		    
		    //�^�ǵ��G
		    $result = array();
		    $result['pid'] = $pid;
		    $result['pic_url'] = "http://fun.wayi.com.tw/attachment/".$new_path;
		    $result['thumb_url'] = $result['pic_url'].'.thumb.jpg';
			$this->response($result, 200);
	    }
	    else
	    {
	    	$this->response('Invalid params', 404);
	    }
    }
    
	//���W�Ǹ��|
	private function get_file_path() {
		$name1 = gmdate('Ym');
		$name2 = gmdate('j');
	
		if(true) {
			$newfilename = $this->config->item('attachdir').'./'.$name1;
			if(!is_dir($newfilename)) {
				mkdir($newfilename);
			}
			$newfilename .= '/'.$name2;
			if(!is_dir($newfilename)) {
				mkdir($newfilename);
			}
		}
		return $name1.'/'.$name2;
	}
	
	//�ͦ��Y��
	function makethumb($srcfile) {

		//�P�_���O�_�s�b
		if (!file_exists($srcfile)) {
			return '';
		}
		$dstfile = $srcfile.'.thumb.jpg';

		//�Y�Ϥj�p
		$tow = intval($this->config->item('thumbwidth'));
		$toh = intval($this->config->item('thumbheight'));
		if($tow < 60) $tow = 60;
		if($toh < 60) $toh = 60;
	
		$make_max = 0;
		$maxtow = intval($this->config->item('maxthumbwidth'));
		$maxtoh = intval($this->config->item('maxthumbheight'));
		if($maxtow >= 300 && $maxtoh >= 300) {
			$make_max = 1;
		}

		//���Ϥ�H��
		$im = '';
		if($data = getimagesize($srcfile)) {
			if($data[2] == 1) {
				$make_max = 0;//gif���B�z
				if(function_exists("imagecreatefromgif")) {
					$im = imagecreatefromgif($srcfile);
				}
			} elseif($data[2] == 2) {
				if(function_exists("imagecreatefromjpeg")) {
					$im = imagecreatefromjpeg($srcfile);
				}
			} elseif($data[2] == 3) {
				if(function_exists("imagecreatefrompng")) {
					$im = imagecreatefrompng($srcfile);
				}
			}
		}
		if(!$im) return '';
		
		$srcw = imagesx($im);
		$srch = imagesy($im);
		
		$towh = $tow/$toh;
		$srcwh = $srcw/$srch;
		if($towh <= $srcwh){
			$ftow = $tow;
			$ftoh = $ftow*($srch/$srcw);
			
			$fmaxtow = $maxtow;
			$fmaxtoh = $fmaxtow*($srch/$srcw);
		} else {
			$ftoh = $toh;
			$ftow = $ftoh*($srcw/$srch);
			
			$fmaxtoh = $maxtoh;
			$fmaxtow = $fmaxtoh*($srcw/$srch);
		}
		if($srcw <= $maxtow && $srch <= $maxtoh) {
			$make_max = 0;//���B�z
		}
		if($srcw > $tow || $srch > $toh) {
			if(function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$ni = imagecreatetruecolor($ftow, $ftoh)) {
				imagecopyresampled($ni, $im, 0, 0, 0, 0, $ftow, $ftoh, $srcw, $srch);
				//�j�Ϥ�
				if($make_max && @$maxni = imagecreatetruecolor($fmaxtow, $fmaxtoh)) {
					imagecopyresampled($maxni, $im, 0, 0, 0, 0, $fmaxtow, $fmaxtoh, $srcw, $srch);
				}
			} elseif(function_exists("imagecreate") && function_exists("imagecopyresized") && @$ni = imagecreate($ftow, $ftoh)) {
				imagecopyresized($ni, $im, 0, 0, 0, 0, $ftow, $ftoh, $srcw, $srch);
				//�j�Ϥ�
				if($make_max && @$maxni = imagecreate($fmaxtow, $fmaxtoh)) {
					imagecopyresized($maxni, $im, 0, 0, 0, 0, $fmaxtow, $fmaxtoh, $srcw, $srch);
				}
			} else {
				return '';
			}

			if(function_exists('imagejpeg')) {
				imagejpeg($ni, $dstfile);
				//�j�Ϥ�
				if($make_max) {
					imagejpeg($maxni, $srcfile);
				}
			} elseif(function_exists('imagepng')) {
				imagepng($ni, $dstfile);
				//�j�Ϥ�
				if($make_max) {
					imagepng($maxni, $srcfile);
				}
			}
			imagedestroy($ni);
			if($make_max) {
				imagedestroy($maxni);
			}
		}
		imagedestroy($im);
		if(!file_exists($dstfile)) {
			return '';
		} else {
			return $dstfile;
		}
	}
	
	//�H�����ͦr��
	private function random($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}
	
	//��o���ɦW
	private function get_extension($name){ 
		if($name){ 
			foreach ($name as $val){ 
				$fname=$val['name']; 
			} 
			$exts = split("[/\\.]", $fname) ; 
			$n = count($exts)-1; 
			$exts = $exts[$n]; 
			return $exts;  
		} 
	} 
}