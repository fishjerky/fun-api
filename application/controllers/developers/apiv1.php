<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiv1 extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('developers');
	}
	
	//�|�����
    public function user()
    {
		$this->template->build('developers/apiv1/user');
    }
    
    //�B��
    public function friends()
    {
		$this->template->build('developers/apiv1/friends');
    }
    
    //��~��
    public function feeds()
    {
		$this->template->build('developers/apiv1/feeds');
    }
    
    //�ۥ�
    public function albums()
    {
		$this->template->build('developers/apiv1/albums');
    }
    
    //������
    public function fans()
    {
		$this->template->build('developers/apiv1/fans');
    }
}