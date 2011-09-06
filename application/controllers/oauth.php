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

		
		//�T�{�ѼƬO�_�s�b
		$client = $this->session->userdata('client_details');
		if ($client == FALSE)
		{
			$this->_fail('[OAuth user error: invalid_request] No client details have been saved. Have you deleted your cookies?', TRUE);
			return;
		}

		//���^�Ѽ�
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
			// �ϥΪ̧����v�C
			// �ͦ��@�ӷs��auth code�ñN�ϥΪ̾ɦ^���ε{��
			if($approve)
			{
				$code = $this->oauth_auth_server->new_auth_code($client->client_id, $uid, $params['redirect_uri'], $params['scope']);
				$redirect_uri = $this->oauth_auth_server->redirect_uri($params['redirect_uri'], array('code='.$code.'&state='.$params['state']));		
			}
			else // �ϥΪ̩ڵ����v�C
				$redirect_uri = $this->oauth_auth_server->redirect_uri($params['redirect_uri'], array('error=access_denied&error_description=The+authorization+server+does+not+support+obtaining+an+authorization+code+using+this+method&state='.$params['state']));
			
			//�M��Session
			$this->session->unset_userdata(array('params'=>'','client_details'=>'', 'sign_in_redirect'=>''));
			
			// ��^���ε{��
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
	 * �ˬd���v
	 */
	function authorize()
	{
		// �ˬd�Ѽ�
		$params = $this->oauth_auth_server->validate_params(array('response_type'=>array('code', 'token'), 'client_id'=>TRUE, 'redirect_uri'=>TRUE, 'scope'=>FALSE, 'state'=>FALSE)); // returns array or FALSE
			
		// �Ѽƿ��~
		if ($params == FALSE )
		{
			$this->_fail('[OAuth client error: invalid_request] The request is missing a required parameter, includes an unsupported parameter or parameter value, or is otherwise malformed.', TRUE);
			return;
		}
					
		//�ˬd client_id �� redirect_uri
		$client_details = $this->oauth_auth_server->validate_client($params['client_id'], NULL, $params['redirect_uri']);
		if ($client_details === FALSE )
		{
			$this->_fail("[OAuth client error: unauthorized_client] The client is not authorised to request an authorization code using this method.", TRUE);
			return;
		}
		$this->session->set_userdata('client_details', $client_details);
		

		//���v�d��
		if (isset($params['scope']) && count($params['scope']) > 0)
		{
			$params['scope'] = explode(',', $params['scope']);
			if ( ! in_array('basic', $params['scope']))
			{
				//�s�W�򥻱��v�d��
				$params['scope'][] = 'basic';
			}
		}
		else
		{
			//�s�W�򥻱��v�d��
			$params['scope'] = array(
				'basic'
			);
		}
			
		//�N�ѼƦs��session
		$this->session->set_userdata(array('params'=>$params));
			
		//�ˬd�O�_�n�J
		$uid = $this->auth->get_uid(); 
			
		//�p�G���ε{���Хܬ��۰ʱ��v
		//�ͦ��@�ӷs�����v�X�ñN�ϥΪ̾ɦ^���ε{��
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
			//�ϥΪ̬O�_�w���v���ε{��
			$authorised = $this->oauth_auth_server->access_token_exists($uid, $params['client_id']); // return TRUE or FALSE
					
			// �p�G�ϥΪ̤w�n�J�ç�����ε{���ӽ�
			// �ͦ��@�ӷs��access token�ñN�ϥΪ̾ɦ^���ε{��
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
			//�����v��ܱ��v�ШD����
			else
				redirect(site_url(array('oauth', 'confirm')), 'location');
		}else
			redirect("http://fun.wayi.com.tw/login.php?callback=http://api.fun.wayi.com.tw/authorize", 'location');	
	}
	
	
	/**
	 * ���oaccess token
	 */
	function token()
	{
		// ���o�Ѽ�
		// ?grant_type=authorization_code&client_id=XXX&client_secret=YYY&redirect_uri=ZZZ&code=123
		$params = $this->oauth_auth_server->validate_params(array('code'=>TRUE, 'client_id'=>TRUE, 'client_secret' => TRUE, 'grant_type' => array('authorization_code') ,'redirect_uri'=>TRUE));
		
		// �Ѽƿ��~
		if ($params == FALSE)
		{
			$this->_fail($this->oauth_auth_server->param_error);
			return;
		}
				
		// �ˬd client_id �� redirect_uri
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
				//�ˬd auth code
				$session_id = $this->oauth_auth_server->validate_auth_code($params['code'], $params['client_id'], $params['redirect_uri']);
				if ($session_id === FALSE)
				{
					$this->_fail("[OAuth client error: invalid_request] Invalid authorization code");
					return;
				}
				
				//���ͷs��access_token�]�ñqsession�R��auth code�^
				$access_token = $this->oauth_auth_server->get_access_token($session_id);
				
				//�^��Access Token
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
		// ���o�Ѽ�
		// ?grant_type=access_token=XXX&scope=YYY
		$params = $this->oauth_auth_server->validate_params(array('access_token'=>TRUE, 'scope'=>FALSE));
		
		// �ˬd�ѼƬO�_���T
		if ($params == FALSE)
		{
			$this->_fail($this->oauth_auth_server->param_error);
			return;
		}
						
		//���v�d��
		$scopes = array('basic');
		if (isset($params['scope']))
		{
			$scopes = explode(',', $params['scope']);
		}
		
		//�ˬd���v�d��
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
	 * ���ͷs�� auth code �ñN�ϥΪ̾ɦ^���ε{��
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
	 * ���ͷs��access token�ñN�ϥΪ̾ɦ^���ε{��
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
	 * ��ܿ��~�T��
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