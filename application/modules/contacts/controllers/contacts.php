<?php
// if(!defined("BASEPTH")) exit("No direct access to the script is allowed.");
/**
* 
*/
class contacts extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('contacts_model');
	}

	function load_all_contacts()
	{
		$data['content_page'] = 'contacts/contacts';
		$data['models'] = $this->ss_load_all_model_contacts();
		// echo "<pre>";print_r($data);die();
		$this->template->call_admin_template($data);
	}

	function ss_load_all_model_contacts()
	{
		$contacts_div = array();
		$model_contacts = $this->contacts_model->get_all_models_contacts();

		foreach ($model_contacts as $key => $value) {
			
			$contacts_div = "<a href='profile.html'>
                    <div class='col-sm-4'>
                        <div class='text-center'>
                            <img alt='image' class='img-circle m-t-xs img-responsive' src='".$value['profile']."'>
                            <div class='m-t-xs font-bold'>".$value['occupation']."</div>
                        </div>
                    </div>
                    <div class='col-sm-8'>
                        <h3><strong>".$value['first_name']." ".$value['last_name']."</strong></h3>
                        <p><i class='fa fa-map-marker'></i>".$value['address']."</p>
                        <address>
                            <strong>Company: ".$value['company']."</strong><br>
                            Email: ".$value['email']."<br>
                            <abbr title='Phone'>Phone:</abbr> ".$value['telephone']."
                        </address>
                    </div>
                    <div class='clearfix'></div>
                </a>";
		}
		// echo "<pre>";print_r($contacts_div);die();
		
        return $contacts_div;
	}
}
?>