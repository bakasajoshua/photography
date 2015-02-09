<?php if (!defined("BASEPATH")) exit("No direct access to the script is allowed");

/**
* 
*/
class admin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->check_login();
	}
	public function index()
	{
		$data['categories'] = $this->getallcategories();
		$data['error'] = '';
		$data['message'] = '';
		$data['events'] = $this->admin_model->get_event_counts();
		$data['models'] = $this->admin_model->get_model_count();
		$data['content_page'] = 'admin/dashboard';

		// echo "<pre>";print_r($data);die();
		$this->template->call_admin_template($data);
		// $this->load->view("template/call_admin_template", $data);
	}

	public function gallery()
	{
		$data['content_page'] = 'admin/gallery';
		$this->template->call_admin_template($data);
	}

	
	public function email_send()
	{
		// echo "Welcome"; die();
		$id = $this->session->userdata('userid');
		$recepient = $this->input->post('email_address');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
		// echo $id." ".$recepient." ".$subject." ".$message;die();
		$this->email($id=NULL, $recepient, $subject, $message);
		redirect('admin');
	}

	public function getallcategories()
	{
		$categories_dropdown = '';
		$query = $this->db->get('categories');
		$result = $query->result_array();

		if ($result) {
			foreach ($result as $key => $value) {
				$categories_dropdown .= '<option value = "'.$value['category_id'].'">'.$value['category_name'].'</option>';
			}
		}

		return $categories_dropdown;
	}

	public function pick()
	{
		$data['content_page'] = 'admin/gallery';
		$this->template->call_admin_template($data);
	}

	
}

?>