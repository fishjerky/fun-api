<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function getstr($string, $length, $in_slashes=0, $out_slashes=0, $html=0) {
		global $_SC, $_SGLOBAL;
	
		$string = trim($string);
	
		if($in_slashes) {
			//傳入的字符有slashes
			$string = sstripslashes($string);
		}
		if($html < 0) {
			//去掉html標籤
			$string = preg_replace("/(\<[^\<]*\>|\r|\n|\s|\[.+?\])/is", ' ', $string);
			$string = shtmlspecialchars($string);
		} elseif ($html == 0) {
			//轉換html標籤
			$string = shtmlspecialchars($string);
		}
		if($length && strlen($string) > $length) {
			//截斷字符
			$wordscut = '';
			if(is_utf8($string)) {
				//utf8編碼
				$n = 0;
				$tn = 0;
				$noc = 0;
				while ($n < strlen($string)) {
					$t = ord($string[$n]);
					if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
						$tn = 1;
						$n++;
						$noc++;
					} elseif(194 <= $t && $t <= 223) {
						$tn = 2;
						$n += 2;
						$noc += 2;
					} elseif(224 <= $t && $t < 239) {
						$tn = 3;
						$n += 3;
						$noc += 2;
					} elseif(240 <= $t && $t <= 247) {
						$tn = 4;
						$n += 4;
						$noc += 2;
					} elseif(248 <= $t && $t <= 251) {
						$tn = 5;
						$n += 5;
						$noc += 2;
					} elseif($t == 252 || $t == 253) {
						$tn = 6;
						$n += 6;
						$noc += 2;
					} else {
						$n++;
					}
					if ($noc >= $length) {
						break;
					}
				}
				if ($noc > $length) {
					$n -= $tn;
				}
				$wordscut = substr($string, 0, $n);
			} else {
				for($i = 0; $i < $length - 1; $i++) {
					if(ord($string[$i]) > 127) {
						$wordscut .= $string[$i].$string[$i + 1];
						$i++;
					} else {
						$wordscut .= $string[$i];
					}
				}
			}
			$string = $wordscut."...";
		}
		if($out_slashes) {
			$string = saddslashes($string);
		}
		return trim($string);
	}
	
	function is_utf8($str){
	    $i=0;
	    $len  =  strlen($str);
	
	    for($i=0;$i<$len;$i++)  {
	        $sbit  =  ord(substr($str,$i,1));
	        if($sbit  <  128)  {
	            //本字節為英文字符，不與理會
	        }elseif($sbit  >  191  &&  $sbit  <  224)  {
	            //第一字節為落於192~223的utf8的中文字(表示該中文為由2個字節所組成utf8中文字)，找下一個中文字
	            $i++;
	        }elseif($sbit  >  223  &&  $sbit  <  240)  {
	            //第一字節為落於223~239的utf8的中文字(表示該中文為由3個字節所組成的utf8中文字)，找下一個中文字
	            $i+=2;
	        }elseif($sbit  >  239  &&  $sbit  <  248)  {
	            //第一字節為落於240~247的utf8的中文字(表示該中文為由4個字節所組成的utf8中文字)，找下一個中文字
	            $i+=3;
	        }else{
	            //第一字節為非的utf8的中文字
	            return  0;
	        }
	    }
	    //檢查完整個字串都沒問體，代表這個字串是utf8中文字
	    return  1;
	}
	
	//SQL ADDSLASHES
	function saddslashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = saddslashes($val);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}
	
	//取消HTML代碼
	function shtmlspecialchars($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = shtmlspecialchars($val);
			}
		} else {
			$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
				str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
		}
		return $string;
	}

	function sstripslashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = sstripslashes($val);
			}
		} else {
			$string = stripslashes($string);
		}
		return $string;
	}

	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		define('UC_KEY', 'd1B1bd06ndEa62T9y0yeQ7CbK4J5EdT6Vc1aP3S7u2f35fw9S7SbX8Dcb84172K8');
		$ckey_length = 4;	// 隨機密鑰長度 取值 0-32;
					// 加入隨機密鑰，可以令密文無任何規律，即便是原文和密鑰完全相同，加密結果也會每次不同，增大破解難度。
					// 取值越大，密文變動規律越大，密文變化 = 16 的 $ckey_length 次方
					// 當此值為 0 時，則不產生隨機密鑰
	
		$key = md5($key ? $key : UC_KEY);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
	
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
	
	function get_avatar_url($uid,$size){    	
    	//分析頭像路徑
    	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
    	$uid = abs(intval($uid));
    	$uid = sprintf("%09d", $uid);
    	$dir1 = substr($uid, 0, 3);
    	$dir2 = substr($uid, 3, 2);
    	$dir3 = substr($uid, 5, 2);
    	$avatarPath ='data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_avatar_$size.jpg";

    	//產生URL
    	if(file_exists('/fundata/bbs/ucserver/'.$avatarPath))
    		$avatarUrl = 'http://bbs.wayi.com.tw/ucserver/'.$avatarPath;
    	else
    		$avatarUrl = 'http://bbs.wayi.com.tw/ucserver/images/noavatar_'.$size.'.gif';
    	return $avatarUrl;
	}