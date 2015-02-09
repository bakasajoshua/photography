<?php if(!defined("BASEPATH")) exit("No direct access to scripts are allowed");
/**
* 
*/
class Home extends MY_Controller
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('m_home');
	}

	function index()
	{
		$data['content_page'] = 'home/home_v';
		$this->template->call_front_end_template($data);
	}

	function about()
	{
		$data['content_page'] = 'home/about_v';
		$this->template->call_front_end_template($data);
	}

	function contact_us()
	{
		$data['content_page'] = 'home/contact_us';
		$this->template->call_front_end_template($data);
	}


	function contact_notification()
	{
		$name = $this->inout->post('name');
		$email = $this->inout->post('email');
		$subject = $this->inout->post('subject');
		$message = $this->inout->post('message');

		$notification = $this->m_home->send_notification($name,$email,$subject,$message);
	}
}