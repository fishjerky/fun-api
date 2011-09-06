<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apps extends CI_Controller {
	function __construct()
	{	
		parent::__construct();
		$this->load->model('Apps_model');
		$this->template->set_layout('developers');
	}
	
	//我的應用程式
	public function my()
	{
		if($this->auth->is_logged_in())
		{
			$myapp = $this->Apps_model->get_my_apps($this->auth->get_uid());
			$this->template->set('myapp',$myapp);
			$this->template->build('developers/apps/my',$myapp);
		}
		else
		{
			$this->template->build('developers/apps/login');
		}

	}
	
	//建立應用程式
	public function create()
	{
		if(strtolower($this->input->server('REQUEST_METHOD')) == 'post'){
			//新增資料
			$uid = $this->auth->get_uid();
			$appname = $this->input->post("appname");
			$description = $this->input->post("description");
			$thumb = $this->input->post("thumb");
			$siteurl = $this->input->post("siteurl");
			$redirect_url = $this->input->post("redirect_uri");
			$this->Apps_model->insert_app($uid,$appname,$description,$siteurl,$thumb,$redirect_url);
			redirect(site_url(array('developers', 'apps', 'my')), 'location');
		}
		$this->template->build('developers/apps/create');
	}
	
	//更新應用程式
	public function update()
	{
		$appid = $this->input->get("appid");
		$uid = $this->auth->get_uid();

		if(strtolower($this->input->server('REQUEST_METHOD')) == 'post'){
			//更新資料
			$appname = $this->input->post("appname");
			$description = $this->input->post("description");
			$thumb = $this->input->post("thumb");
			$siteurl = $this->input->post("siteurl");
			$redirect_url = $this->input->post("redirect_uri");
			$this->Apps_model->update_app($appid,$appname,$description,$siteurl,$thumb,$redirect_url);
			redirect(site_url(array('developers', 'apps', 'my')), 'location');
		}

		$app = $this->Apps_model->get_my_apps($uid,$appid);
		$this->template->set('app',$app);
		$this->template->build('developers/apps/update');
	}
	
	public function delete()
	{
		$appid = $this->input->get("appid");
		$this->Apps_model->delete_app($appid);
		redirect(site_url(array('developers', 'apps', 'my')), 'location');
	}
}