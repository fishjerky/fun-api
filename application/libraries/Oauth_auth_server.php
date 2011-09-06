<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Oauth_auth_server {

	protected $CI;

	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	 * 檢查參數是否存在
	 * 
	 * @access public
	 * @param array $params
	 * @return bool|array
	 */
	public function validate_params($params = array())
	{
		if (count($params) > 0)
		{
			$vars = array();
			foreach ($params as $param => $options)
			{
				$i = trim($this->CI->input->get($param, TRUE));
				
				if (($i === FALSE || $i == "") && $options !== FALSE)
				{
					$this->param_error = "Missing or empty parameter `{$param}`";
					return FALSE;
				}
				
				if (is_array($options))
				{
					if (in_array($i, $options) == FALSE)
					{
						$this->param_error = "`{$param}` should be equal to: '" . implode("' or '", $options) . "'";
						return FALSE;
					}
				}
				
				$vars[$param] = trim($i);
			}
			
			return $vars;
		}
	}
	
	
	/**
	 * 檢查授權狀態
	 * 
	 * @access public
	 * @param string $client_id
	 * @param mixed $client_secret
	 * @param mixed $redirect_uri
	 * @return bool|object
	 */
	function validate_client($client_id = "", $client_secret = NULL, $redirect_uri = NULL)
	{
		$params = array(
			'appid' => $client_id,
		);
		
		if ($client_secret !== NULL)
		{
			$params['client_secret'] = $client_secret;
		}
		
		if ($redirect_uri !== NULL)
		{
			$params['redirect_uri'] = $redirect_uri;
		}

		$client_check_query = $this->CI->db->select(array('appname as name', 'appid as client_id','thumb as logo', 'auto_approve'))->get_where('uchome_app', $params);
		if ($client_check_query->num_rows() > 0)
		{
			return $client_check_query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	/**
	 * 產生auth code
	 * 
	 * @access public
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @param mixed $redirect_uri
	 * @param array $scopes
	 * @return string
	 */
	function new_auth_code($client_id = '', $user_id = '', $redirect_uri = '', $scopes = array())
	{
		// 如果使用者已經有access token
		$token_exists = $this->CI->db->select('access_token')->where(array('user_id' => $user_id, 'client_id' => $client_id))->count_all_results('oauth_sessions');
		
		// 更新session
		if ($token_exists == 1)
		{
			$code = md5(time().uniqid());
			
			$this->CI->db->where(array('user_id' => $user_id, 'client_id'=>$client_id))->update('oauth_sessions', array('code' => $code, 'access_token' => NULL, 'stage' => 'request', 'last_updated' => time()));
		}
		
		// 產生 oauth session
		else
		{
			$code = md5(time().uniqid());
			
			$this->CI->db->insert('oauth_sessions', array('client_id' => $client_id, 'redirect_uri' => $redirect_uri, 'user_id' => $user_id, 'code' => $code, 'first_requested' => time(), 'last_updated' => time()));
			$insert_id = $this->CI->db->insert_id();
			
			//新增授權範圍
			if (count($scopes) > 0)
			{
				foreach ($scopes as $scope)
				{
					$scope = trim($scope);
					
					if(trim($scope) !== "")
					{
						$this->CI->db->insert('oauth_session_scopes', array('session_id' => $insert_id, 'scope'=>$scope));
					}
				}
			}
		}
		
		return $code;
	}
	
	
	/**
	 * 檢查 auth_code
	 * 
	 * @access public
	 * @param string $code
	 * @param string $client_id
	 * @param string $redirect_uri
	 * @return bool|int
	 */
	function validate_auth_code($code = "", $client_id = "", $redirect_uri = "")
	{
		$validate = $this->CI->db->select(array('id'))->get_where('oauth_sessions', array('client_id' => $client_id, 'redirect_uri' => $redirect_uri, 'code' => $code));
		
		if ($validate->num_rows() == 0)
		{
			return FALSE;
		}
		
		else
		{
			$result = $validate->row();
			return $result->id;
		}
	}
	
	
	/**
	 * 取得access token
	 * 
	 * @access public
	 * @param string $session_id. (default: '')
	 * @return string
	 */
	function get_access_token($session_id = '')
	{
		// 檢查 access token 是否已經存在
		$exists_query = $this->CI->db->select('access_token')->get_where('oauth_sessions', array('id' => $session_id, 'access_token IS NOT NULL' => NULL));
		
		// 如果 access token 已經存在返回 access token並清除auth code
		if ($exists_query->num_rows() == 1)
		{
			//清除auth code
			$this->CI->db->where(array('id' => $session_id))->update('oauth_sessions', array('code'=>NULL));
			
			//返回 access token
			$exists = $exists_query->row();
			return $exists->access_token;
		}
		
		// access token不存在，建新access token及清除auth code
		else
		{
			$access_token = time().'|'.md5(uniqid());
			
			$updates = array(
				'code' => NULL,
				'access_token' => $access_token,
				'last_updated' => time(),
				'stage' => 'granted'
			);
			
			//更新 OAuth session
			$this->CI->db->where(array('id' => $session_id))->update('oauth_sessions', $updates);
			
			// Update the session scopes with the access token
			$this->CI->db->where(array('session_id' => $session_id))->update('oauth_session_scopes', array('access_token' => $access_token));
						
			return $access_token;
		}
	}
	
	
	/**
	 * 產生新access_token
	 * 
	 * @access public
	 * @param string $client_id. (default: '')
	 * @param string $user_id. (default: '')
	 * @param string $redirect_uri. (default: '')
	 * @param array $scopes. (default: array())
	 * @param int $limited. (default: 0)
	 * @return void
	 */
	function new_access_token($client_id = '', $user_id = '', $redirect_uri = '', $scopes = array(), $limited = 0)
	{
		$access_token = time().'|'.md5(uniqid());
		
		$this->CI->db->insert('oauth_sessions', array('client_id' => $client_id, 'redirect_uri' => $redirect_uri, 'user_id' => $user_id, 'access_token' => $code, 'first_requested' => time(), 'last_updated' => time(), 'code' => NULL, 'limited' => $limited));
		$insert_id = $this->CI->db->insert_id();
		
		// 新增授權範圍
		if (count($scopes) > 0)
		{
			foreach ($scopes as $scope)
			{
				$scope = trim($scope);
				
				if(trim($scope) !== "")
				{
					$this->CI->db->insert('oauth_session_scopes', array('session_id' => $insert_id, 'scope'=>$scope));
				}
			}
		}
		
		return $access_token;
	}
	
	
	/**
	 * 檢查 access token
	 * 
	 * @access public
	 * @param string $access_token. (default: "")
	 * @param array $scope. (default: array())
	 * @return void
	 */
	function validate_access_token($access_token = '', $scopes = array())
	{

		//檢查access token是否存在
		$valid_token = $this->CI->db->where(array('access_token' => $access_token))->count_all_results('oauth_sessions');

		// access token不存在
		if ($valid_token == 0)
		{
			return FALSE;
		}

		// 檢查access token授權範圍
		else
		{
			if (count($scopes) > 0)
			{
				foreach ($scopes as $scope)
				{
					$scope_exists = $this->CI->db->where(array('access_token' => $access_token, 'scope' => $scope))->count_all_results('oauth_session_scopes');
					
					if ($scope_exists == 0)
					{
						return FALSE;
					}
				}
				return TRUE;
			}
			
			else
			{
				return TRUE;
			}
		}
		
	}
	
	/**
	 * 取得使用者資訊
	 * 
	 * @access public
	 * @param string $access_token
	 * @return array
	 */
	function get_user($access_token)
	{
		//利用access_toke取得使用者資訊
    	$this->CI->db->select('client_id as appid,uid,username')->from('uchome_member um')->join('oauth_sessions os', 'um.uid = os.user_id')->where('access_token', $access_token);
    	$user = $this->CI->db->get()->row_array();
		if ($user)
		{
			return $user;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Tests if a user has already authorized an application and an access token has been granted
	 * 
	 * @access public
	 * @param string $user_id
	 * @param string $client_id
	 * @return bool
	 */
	function access_token_exists($user_id = '', $client_id = '')
	{
		$token_query = $this->CI->db->select('access_token')->get_where('oauth_sessions', array('client_id' => $client_id, 'user_id'=>$user_id, 'access_token !=' => ''));
		
		if ($token_query->num_rows() == 1)
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	
	/**
	 * Generates the redirect uri with appended params
	 * 
	 * @access public
	 * @param string $redirect_uri. (default: "")
	 * @param array $params. (default: array())
	 * @return string
	 */
	function redirect_uri($redirect_uri = '', $params = array(), $query_delimeter = '?')
	{
		if (strstr($redirect_uri, $query_delimeter))
		{
			$redirect_uri = $redirect_uri . implode('&', $params);
		}
		else
		{
			$redirect_uri = $redirect_uri . $query_delimeter . implode('&', $params);
		}
		
		return $redirect_uri;
	}	
}