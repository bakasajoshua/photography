<?php if(!defined("BASEPATH")) exit("No direct access to scripts are allowed");
/**
* 
*/
class events extends MY_Controller
{
	var $event_details;
	// var $path = base_url().'image_uploads/eventsprofile';
	function __construct()
	{
		parent:: __construct();
		$this->load->model('events_model');
		$this->check_login();
	}

	public function index()
	{
		$this->event_list();
	}

	public function event_list()
	{
		$data['events_count'] = $this->events_model->get_event_counts();
		$data['content_page'] = 'events/events';
		$data['events'] = $this->ss_all_events();
		// echo "<pre>";print_r($data);die();
		$this->template->call_admin_template($data);
	}

	public function add_event()
	{
		$data['content_page'] = 'events/add_event';

		$this->template->call_admin_template($data);
	}

	public function register_event()
	{
		$success = FALSE;
		$upload_image = 'cover';
		$upload_path = 'image_uploads/eventsprofiles';

		$uploaded = $this->upload->uploadanimage($upload_image, $upload_path);

		if($uploaded)
		{
			$path = $uploaded['path'];
			$date = $_POST['day'];

			$new_date = strtotime($date);
			$new_date = date('Y-m-d', $new_date);
			
			$_POST['day'] = $new_date;
			$_POST['cover'] = $path;
			$returned = $this->events_model->addevent();

			if($returned)
			{
				$success = TRUE;
				$data['notification'] = 'success';
				$data['message'] = 'Successfully added event <br /> Check it below';
			}
			else
			{
				$success = FALSE;
				$data['notfication'] = 'failed';
				$data['message'] = 'There was a problem adding Event. Please Try Again';
			}
		}
		else
		{
			$success = FALSE;
			$data['notification'] = FALSE;
			$data['message'] = 'There was a problem while uploading your image. Please try again';
		}

		if($success){
			$this->event_list();
		}
		else{
			$data['content_page'] = 'events/add_event';
			$this->template->call_admin_template($data);
		}
	}

	public function event_profile($event_id)
	{
		$eve_details = $this->events_model->get_events_profile($event_id);
		$data['content_page'] = 'events/event_profile';
		$data['eve_details'] = $this->events_model->get_events_profile($event_id);
		$data['months'] = $this->start_to_end($eve_details[0]['start_month']);
		$data['event_images'] = $this->ss_event_images($event_id);
		// echo "<pre>";print_r($data);die();
		$this->template->call_admin_template($data);
	}

	
public function ss_all_events()
	{
		$eve_details = $this->events_model->call_all_events();
		// echo "<pre>";print_r($eve_details);die();
		$count = 0;
		$this->event_details .= "<tbody>";
		if ($eve_details == NULL) {
				$this->event_details .= '<tr>';
				$this->event_details .= '<td colspan="5"><center>No record found in the database...</center></td>';
				$this->event_details .= '</tr>';
		} else {
			foreach ($eve_details as $key => $value) {
				$month = $this->start_to_end($value['start_month']);
				$count++;
				$this->event_details .= '<tr>';
				$this->event_details .= '<td>'.$count.'</td>';
				$this->event_details .= '<td>'.$value['event_name'].'</td>';
				$this->event_details .= '<td>'.$value['place'].'</td>';
				$this->event_details .= '<td>'.$month.' '.$value['start_Date'].' , '.$value['start_year'].'</td>';
				$this->event_details .= '<td><a href = "'.base_url().'events/event_profile/'.$value['event_id'].'">View event</a></td>';
				$this->event_details .= '</tr>';
			}
		}
		$this->event_details .= "</tbody>";

		// echo "<pre>";print_r($this->event_details);die();
		return $this->event_details;
	}

	function add_images($event_id)
	{
		$data['content_page'] = 'events/add_images';
		$this->template->call_admin_template($data);
	}

	private function ss_event_images($event_id)
	{
		$images = $this->events_model->get_events_images($event_id);
		// echo "<pre>";print_r($images);die();

		if ($images) {
			foreach ($images as $key => $value) {
				// echo "<pre>";print_r($value['image_path']);die();
				$path = $value['image_path'];
                $load_images = '<a class="fancybox" href="'.$value['image_path'].'" title="Picture 1">
		                            <img alt="image"  src="'.$path.'" />
		                        </a>';
			}
		} else {
			$load_images = '<div class = "empty"><center><h2>No Images of this event uploaded yet. </h2><a class = "btn btn-primary btn-outline" href = "'.base_url().'events/add_images/'.$event_id.'">Add Images here</a></center>
			</div>';
		}
		
		// echo "<pre>";print_r($load_div);die();
		
        return $load_images;
	}

	
	public function upload_file()
	{
		print_r($_FILES);

		if($_FILES['file']){
			if(strtolower(substr($_FILES['file']['name'], -3)) == "jpg"){
				$this->results_array = $this->read_abbott($this->upload->read_file_array($_FILES['file']['tmp_name'],"jpg"));
				$this->save_image($this->results_array);

			}elseif(strtolower(substr($_FILES['file']['name'], -3)) == "jpeg"){
				$this->results_array = $this->read_cobas($this->upload->read_file_array($_FILES['file']['tmp_name'],"jpeg"));				
				$this->save_image($this->results_array);
			}else{
			}
		}

		//print_r($this->results_array);

	}

	private function read_abbott($abbot_array){

		// print_r($abbot_array);

		if($abbot_array[0][0]=="FILE SIGNATURE"){

			$completed_time 							= $abbot_array[6][1];
			$operator									= $abbot_array[14][1];
			$samp_prep_lot_no							= $abbot_array[15][1];
			$samp_prep_exp_date							= $abbot_array[16][1];
			$samples =array();

			$samples_start_row=21;

			for ($i=0; $i <= 99; $i++) { 
				if($i!=48	&& 	$i!=49){

					$samples[$i]["completed_time"]			=	$completed_time;
					$samples[$i]["sample_id"] 				=	$abbot_array[$samples_start_row][1];
					$samples[$i]["sample_location"] 		=	$abbot_array[$samples_start_row][0];
					$samples[$i]["operator"]				=	$operator;
					$samples[$i]["samp_prep_lot_no"]		=	$samp_prep_lot_no;
					$samples[$i]["samp_prep_exp_date"]		=	$samp_prep_exp_date;

					if($abbot_array[$samples_start_row][5]=="Not Detected"){

						$samples[$i]["result"] 				= "N";
					}else if($abbot_array[$samples_start_row][5]=="HIV-1 Detected"){

						$samples[$i]["result"] 				= "P";

					}else if($abbot_array[$samples_start_row][5]=="HIV-2 Detected"){

						$samples[$i]["result"] 				= "P";
					}else {

						$samples[$i]["result"] 				= "F";
					}

					$samples_start_row++;
				}
			}

			// print_r($samples);

			return $samples;
		}
	}

	private function read_cobas($cobas_array){
		// print_r($cobas_array);

		if($cobas_array[0][0]=="Patient Name"){

			$samples 	=	array();

			for ($i=0; $i <= 23; $i++) { 

				$samples[$i]["sample_id"] 			=	$cobas_array[$i+2][2];
				$samples[$i]["sample_location"] 	=	$cobas_array[$i+2][35];
				$samples[$i]["completed_time"]		=	$cobas_array[$i+2][3];
				$samples[$i]["gen_lot_no"]			=	$cobas_array[$i+2][14];
				$samples[$i]["gen_lot_exp_date"]	=	$cobas_array[$i+2][15];

				if($cobas_array[$i+2][8]=="Target Not Detected"){

					$samples[$i]["result"] 				= "N";
				}else if((int)$cobas_array[$i+2][8]==1){

					$samples[$i]["result"] 				= "P";

				}else {

					$samples[$i]["result"] 				= "F";
				}
			}

			//print_r($samples);

			return $samples;
		}
	}

	private function save_image($res=array())
	{

		// $from_date = date('Y-m-d', strtotime('today - 90 days'));

		// $samples 	=	R::getAll("SELECT * FROM `sample` WHERE `timestamp` > '$from_date' ");

		$results_to_upload = array();

		foreach ($res as $key => $value) {
			foreach ($samples as $key1 => $value1) {
				if((int)$value1['id']==(int)$value['sample_id']){
					$results_to_upload[]=$value;
				}
			}
		}

		foreach ($results_to_upload as $key => $value) {
			$sql = "INSERT INTO `sample_test_run` (`sample_id`,`result`) VALUES('".$value["sample_id"]."','".$value["result"]."')";
			$this->db->query($sql);
		}

	}

	public function start_to_end($begin)
	{

		//If statement to convert the number to names of the months for start
				if ($begin==1) {$start = 'January'; }else if($begin==2) {$start = 'February'; } else if($begin==3) {$start = 'March'; }else if($begin==4) {$start = 'April'; }else if($begin==5) {$start = 'May'; }
					else if($begin==6) {$start = 'June'; }else if($begin==7) {$start = 'July'; }else if($begin==8) {$start = 'August'; }else if($begin==9) {$start = 'September'; }
						else if($begin==10) {$start = 'October'; }else if($begin==11) {$start = 'November'; }else if($begin==12) {$start = 'December'; }

			return $start;
	}

}
?>