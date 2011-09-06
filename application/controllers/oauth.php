<?php
class Oauth extends CI_Controller {
		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('oauth_auth_server');
	}
	
	function confirm()
	{
		$uid = $this->auth->get_uid();
		if ($uid == FALSE)
			redirect("http://fun.wayi.com.tw/login.php?callback=http://api.fun.wayi.com.tw/authorize", 'location');	

		
		//確認參數是否存在
		$client = $this->session->userdata('client_details');
		if ($client == FALSE)
		{
			$this->_fail('[OAuth user error: invalid_request] No client details have been saved. Have you deleted your cookies?', TRUE);
			return;
		}

		//取回參數
		$params = $this->session->userdata('params');
		if ($params == FALSE)
		{
			$this->_fail('[OAuth user error: invalid_request] No OAuth parameters have been saved. Have you deleted your cookies?', TRUE);
			return;
		}
		
		$approve = $this->input->post('approve');
		$deny = $this->input->post('deny');

		if ($approve || $deny)
		{	
			// 使用者批准授權。
			// 生成一個新的auth code並將使用者導回應用程式
			if($approve)
			{
				$code = $this->oauth_auth_server->new_auth_code($client->client_id, $uid, $params['redirect_uri'], $params['scope']);
				$redirect_uri = $this->oauth_auth_server->redirect_uri($params['redirect_uri'], array('code='.$code.'&state='.$params['state']));		
			}
			else // 使用者拒絕授權。
				$redirect_uri = $this->oauth_auth_server->redirect_uri($params['redirect_uri'], array('error=access_denied&error_description=The+authorization+server+does+not+support+obtaining+an+authorization+code+using+this+method&state='.$params['state']));
			
			//清除Session
			$this->session->unset_userdata(array('params'=>'','client_details'=>'', 'sign_in_redirect'=>''));
			
			// 返回應用程式
			redirect($redirect_uri, 'location');	
		}
		else
		{
			$vars = array(
				'name' => $client->name,
				'logo' => $client->logo
			);
			$this->load->view('oauth/confirm', $vars);
		}
	}
	
	/**
	 * 檢查授權
	 */
	function authorize()
	{
		// 檢查參數
		$params = $this->oauth_auth_server->validate_params(array('response_type'=>array('code', 'token'), 'client_id'=>TRUE, 'redirect_uri'=>TRUE, 'scope'=>FALSE, 'state'=>FALSE)); // returns array or FALSE
			
		// 參數錯誤
		if ($params == FALSE )
		{
			$this->_fail('[OAuth client error: invalid_request] The request is missing a required parameter, includes an unsupported parameter or parameter value, or is otherwise malformed.', TRUE);
			return;
		}
					
		//檢查 client_id 及 redirect_uri
		$client_details = $this->oauth_auth_server->validate_client($params['client_id'], NULL, $params['redirect_uri']);
		if ($client_details === FALSE )
		{
			$this->_fail("[OAuth client error: unauthorized_client] The client is not authorised to request an authorization code using this method.", TRUE);
			return;
		}
		$this->session->set_userdata('client_details', $client_details);
		

		//授權範圍
		if (isset($params['scope']) && count($params['scope']) > 0)
		{
			$params['scope'] = explode(',', $params['scope']);
			if ( ! in_array('basic', $params['scope']))
			{
				//新增基本授權範圍
				$params['scope'][] = 'basic';
			}
		}
		else
		{
			//新增基本授權範圍
			$params['scope'] = array(
				'basic'
			);
		}
			
		//將參數存於session
		$this->session->set_userdata(array('params'=>$params));
			
		//檢查是否登入
		$uid = $this->auth->get_uid(); 
			
		//如果應用程式標示為自動授權
		//生成一個新的授權碼並將使用者導回應用程式
		if ($uid && $client_details->auto_approve == 1)
		{
			if ($params['response_type'] == 'token') // user agent flow
			{
				$this->fast_token_redirect($client_details->client_id, $uid, $params['redirect_uri'], $params['scope'], $params['state']);
			}
			else // web server flow
			{
				$this->fast_code_redirect($client_details->client_id, $uid, $params['redirect_uri'], $params['scope'], $params['state']);
			}
		}
			
		if ($uid){
			//使用者是否已授權應用程式
			$authorised = $this->oauth_auth_server->access_token_exists($uid, $params['client_id']); // return TRUE or FALSE
					
			// 如果使用者已登入並批准應用程式申請
			// 生成一個新的access token並將使用者導回應用程式
			if ($authorised)
			{
				if ($params['response_type'] == 'token') // user agent flow
				{
					$this->fast_token_redirect($client_details->client_id, $uid, $params['redirect_uri'], $params['scope'], $params['state']);
				}
				else // web server flow
				{
					$this->fast_code_redirect($client_details->client_id, $uid, $params['redirect_uri'], $params['scope'], $params['state']);
				}
			}			
			//未授權顯示授權請求頁面
			else
				redirect(site_url(array('oauth', 'confirm')), 'location');
		}else
			redirect("http://fun.wayi.com.tw/login.php?callback=http://api.fun.wayi.com.tw/authorize", 'location');	
	}
	
	
	/**
	 * 取得access token
	 */
	function token()
	{
		// 取得參數
		// ?grant_type=authorization_code&client_id=XXX&client_secret=YYY&redirect_uri=ZZZ&code=123
		$params = $this->oauth_auth_server->validate_params(array('code'=>TRUE, 'client_id'=>TRUE, 'client_secret' => TRUE, 'grant_type' => array('authorization_code') ,'redirect_uri'=>TRUE));
		
		// 參數錯誤
		if ($params == FALSE)
		{
			$this->_fail($this->oauth_auth_server->param_error);
			return;
		}
				
		// 檢查 client_id 及 redirect_uri
		$client_details = $this->oauth_auth_server->validate_client($params['client_id'], NULL, $params['redirect_uri']); // returns object or FALSE
		if ($client_details === FALSE )
		{
			$this->_fail("[OAuth client error: unauthorized_client] The client is not authorised to request an authorization code using this method.", TRUE);
			return;
		}
		
		// Respond to the grant type
		switch($params['grant_type'])
		{
			case "authorization_code":
				//檢查 auth code
				$session_id = $this->oauth_auth_server->validate_auth_code($params['code'], $params['client_id'], $params['redirect_uri']);
				if ($session_id === FALSE)
				{
					$this->_fail("[OAuth client error: invalid_request] Invalid authorization code");
					return;
				}
				
				//產生新的access_token（並從session刪除auth code）
				$access_token = $this->oauth_auth_server->get_access_token($session_id);
				
				//回傳Access Token
				$this->_response(array('access_token' => $access_token, 'token_type' => '', 'expires_in' => NULL, 'refresh_token' => NULL));
				return;
			break;

			//refresh tokens
		}	
	}
		
	
	/**
	 * Resource servers will make use of this URL to validate an access token
	 */
	function verify_access_token()
	{
		// 取得參數
		// ?grant_type=access_token=XXX&scope=YYY
		$params = $this->oauth_auth_server->validate_params(array('access_token'=>TRUE, 'scope'=>FALSE));
		
		// 檢查參數是否正確
		if ($params == FALSE)
		{
			$this->_fail($this->oauth_auth_server->param_error);
			return;
		}
						
		//授權範圍
		$scopes = array('basic');
		if (isset($params['scope']))
		{
			$scopes = explode(',', $params['scope']);
		}
		
		//檢查授權範圍
		$result = $this->oauth_auth_server->validate_access_token($params['access_token'], $scopes);
		
		if ($result)
		{		
			$resp = array(
				'access_token'=>$params['access_token'],
			);
			
			$this->_response($resp);
		}
		
		else
		{
			$this->_fail('Invalid `access_token`', FALSE);
			return;
		}
		

	}
	
	
	/**
	 * 產生新的 auth code 並將使用者導回應用程式
	 * web-server flow
	 * 
	 * @access private
	 * @param string $client_id
	 * @param string $uid
	 * @param string $redirect_uri
	 * @param array $scope
	 * @param string $state
	 * @return void
	 */
	private function fast_code_redirect($client_id = "", $uid = "", $redirect_uri = "", $scopes = array(), $state = "")
	{
		$code = $this->oauth_auth_server->new_auth_code($client_id, $uid, $redirect_uri, $scopes);
		$redirect_uri = $this->oauth_auth_server->redirect_uri($redirect_uri, array('code='.$code."&state=".$state));
		
		$this->session->unset_userdata(array('params'=>'','client_details'=>'', 'sign_in_redirect'=>''));
		redirect($redirect_uri, 'location');	
	}
	
	/**
	 * 產生新的access token並將使用者導回應用程式
	 * user-agent flow
	 * 
	 * @access private
	 * @param string $client_id
	 * @param string $uid
	 * @param string $redirect_uri
	 * @param array $scope
	 * @param string $state
	 * @return void
	 */
	private function fast_token_redirect($client_id = "", $uid = "", $redirect_uri = "", $scopes = array(), $state = "")
	{
		// Creates a limited access token due to lack of verification/authentication
		$token = $this->oauth_auth_server->new_auth_code($client_id, $uid, $redirect_uri, $scopes, 1);
		$redirect_uri = $this->oauth_auth_server->redirect_uri($redirect_uri, array('code='.$code."&state=".$state), '#');
		
		$this->session->unset_userdata(array('params'=>'','client_details'=>'', 'sign_in_redirect'=>''));
		redirect($redirect_uri, 'location');	
	}
	
	
	/**
	 * 顯示錯誤訊息
	 * 
	 * @access private
	 * @param mixed $msg
	 * @return string
	 */
	private function _fail($msg, $friendly=FALSE)
	{
		if ($friendly)
		{
			show_error($msg, 500);
		}
		
		else
		{
			$this->output->set_status_header('500');
			$this->output->set_header('Content-type: text/plain');
			$this->output->set_output(json_encode(array('error'=>1, 'error_message'=>$msg)));
		}
	}
	
	
	/**
	 * JSON response
	 * 
	 * @access private
	 * @param mixed $msg
	 * @return string
	 */
	private function _response($msg)
	{
		$msg['error'] = 0;
		$msg['error_message'] = '';
		$this->output->set_status_header('200');
		$this->output->set_header('Content-type: text/plain');
		$this->output->set_output(json_encode($msg));	
	}

}