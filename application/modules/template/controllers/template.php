<?php if (!defined("BASEPATH")) exit("No direct access to the script is allowed");

class Template extends MY_Controller
{
	var $user_details;
	function __construct()
	{
		parent::__construct();
		$this->load->model('template_model');
		$this->get_details();
	}

	function call_admin_template($data = NULL)
	{
		$data['user_details'] = $this->user_details[0];
		$this->load->view('admin_template', $data);
	}

	function call_front_end_template($data = NULL)
	{
		$this->load->view('front_end');
	}

	function get_details()
	{
		$this->user_details = $this->template_model->get_user_details();
	}
}