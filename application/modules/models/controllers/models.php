<?php if (!defined("BASEPATH")) exit("No direct access to the script is allowed");

/**
* 
*/
class Models extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_models');
		// $this->check_login();
	}

	public function getlatestaddition()
	{
		$addeddate = $this->m_models->getmodeladditiondate();
		if($addeddate)
		{

			$addeddate = date('dS F, Y', strtotime($addeddate));
		}
		else
		{
			$addeddate = 'None';
		}
		return $addeddate;
	}
	public function modellist()
	{
		$data['display_date'] = $this->getlatestaddition();
		$data['model_count'] = $this->m_models->getmodelcount();
		$data['table'] = $this->createmodels('table');
		$data['grid'] = $this->createmodels();
		$data['content_page'] = 'models/v_models';
		// echo "<pre>";print_r($data['grid']);die();
		$this->template->call_admin_template($data);
	}
	public function newmodel()
	{
		$data['content_page'] = 'models/addmodel';
		$this->template->call_admin_template($data);
	}

	public function addmodel()
	{
		$success = FALSE;
		$upload_image = 'profile';
		$upload_path = 'image_uploads/modelprofiles';

		$uploaded = $this->upload->uploadanimage($upload_image, $upload_path);

		if($uploaded)
		{
			$path = $uploaded['path'];
			$date = $_POST['dob'];

			$new_date = strtotime($date);
			$new_date = date('Y-m-d', $new_date);
			
			$_POST['dob'] = $new_date;
			$_POST['profile'] = $path;
			$returned = $this->m_models->addmodel();

			if($returned)
			{
				$success = TRUE;
				$data['notification'] = 'success';
				$data['message'] = 'Successfully added model <br /> Check him or her below';
			}
			else
			{
				$success = FALSE;
				$data['notfication'] = 'failed';
				$data['message'] = 'There was a problem adding Model. Please Try Again';
			}
		}
		else
		{
			$success = FALSE;
			$data['notification'] = FALSE;
			$data['message'] = 'There was a problem while uploading your image. Please try again';
		}

		if($success){
			$model_id = mysql_insert_id();
			$encryption = $this->security->encrypt_data($model_id);
			redirect(base_url(). 'models/modelprofile/' . $encryption);
		}
		else{
			$data['content_page'] = 'models/addmodel';
			$this->template->call_admin_template($data);
		}
	}

	public function createmodels($type = 'grid')
	{
		$models_section = '';
		$models = $this->m_models->getallmodels();
		if($models)
		{
			switch ($type) {
			case 'grid':
				foreach ($models as $key => $value) {
					$display_date = date('dS F, Y', strtotime($value['dob']));
					$models_section .= '<div class="col-lg-4">
			        <div class="contact-box">
			            <a href="'.base_url().'models/modelprofile/'.$this->security->encrypt_data($value['model_id']).'">
			            <div class="col-sm-4">
			                <div class="text-center">
			                    <img alt="image" class="m-t-xs img-responsive model-image" src="'.$value['profile'].'">
			                    <div class="m-t-xs font-bold">'.$value['occupation'].'</div>
			                </div>
			            </div>
			            <div class="col-sm-8">
			                <h3><strong>'.$value['first_name'].' '.$value['last_name'].'</strong></h3>
			                <p><i class="fa fa-birthday-cake"></i> '.$display_date.'</p>
			                <address>
			                    <strong>'.$value['company'].'</strong><br>
			                    '.$value['email'].'<br>
			                    <abbr title="Phone">P:</abbr> '.$value['telephone'].'
			                </address>
			            </div>
			            <div class = "col-sm-12">
			            	<a href ="'.base_url().'models/modelprofile/'.$this->security->encrypt_data($value['model_id']).'" class = "btn btn-success btn-sm"><i class = "fa fa-eye"></i>&nbsp;Profile</a>&nbsp;&nbsp;';
			            if($value['active'] == 1)
						{
							$models_section .= '<a href = "#" class = "btn btn-primary btn-sm activator" id = "activation" data-what = "deactivate" data-id = "'.$value['model_id'].'" data-toggle="modal" data-target="#myModal" data-crypt = "'.$this->security->encrypt_data($value['model_id']).'"><i class = "fa fa-check"></i>&nbsp;Active</a>';
						}
						else
						{
							$models_section .= '<a href = "#" class = "btn btn-danger btn-sm activator" id = "activation" data-what = "activate" data-id = "'.$value['model_id'].'" data-toggle="modal" data-target="#myModal" data-crypt = "'.$this->security->encrypt_data($value['model_id']).'"><i class = "fa fa-times"></i>&nbsp;Deactivated</a>';
						}
			            $models_section .= '&nbsp;<a href = "" class = "btn btn-info btn-sm"><i class = "fa fa-file-image-o"></i>&nbsp;Photos</a>
			            </div>
			            <div class="clearfix"></div>
			                </a>
			        </div>
			    </div>';
				}
				break;
			
			case 'table':
				$counter = 1;
				foreach ($models as $key => $value) {
					$display_date = date('dS F, Y', strtotime($value['dob']));
					$models_section .= '<tr>';
					$models_section .= '<td>'.$counter.'</td>';
					$models_section .= '<td>'.$value['first_name'].'</td>';
					$models_section .= '<td>'.$value['last_name'].'</td>';
					$models_section .= '<td>'.$value['email'].'</td>';
					$models_section .= '<td>'.$value['telephone'].'</td>';
					$models_section .= '<td>'.$display_date.'</td>';
					$models_section .= '<td><a href = "'.base_url().'models/modelprofile/'.$this->security->encrypt_data($value['model_id']).'">View Profile</a></td>';
					$models_section .= '<td>';
					if($value['active'] == 1)
					{
						$models_section .= '<a href = "#" class = "label label-primary activator" id = "activation" data-what = "deactivate" data-id = "'.$value['model_id'].'" data-toggle="modal" data-target="#myModal"  data-crypt = "'.$this->security->encrypt_data($value['model_id']).'">Active</a>';
					}
					else
					{
						$models_section .= '<a href = "#" class = "label label-danger activator" id = "activation" data-what = "activate" data-id = "'.$value['model_id'].'" data-toggle="modal" data-target="#myModal"  data-crypt = "'.$this->security->encrypt_data($value['model_id']).'">Deactivated</a>';
					}
					$models_section .= '</td>';
					$models_section .= '</tr>';

					$counter++;
				}
				break;
			default:
				
				break;
			}
		}
		else
		{
			$models_section = '<div class = "empty"><center><h2>No Models Registered Yet. </h2><a class = "btn btn-primary btn-outline" href = "'.base_url().'models/newmodel">Add one Here</a></center>
			</div>';
		}

		return $models_section;
	}

	function modelprofile($model_id)
	{
		$model_id = $this->security->decrypt_data($model_id);

		$models = $this->m_models->getmodelbyid($model_id);

		$data['model_details'] = $models[$model_id];
		$data['content_page'] = 'models/model_profile';
		
		$this->template->call_admin_template($data);

	}

	function upload_model_photo()
	{
		$pictures_array = array();
		$ds = '/';
		$store_folder = 'image_uploads';
		if(!empty($_FILES))
		{
			foreach ($_FILES as $key => $value) {
				foreach ($value as $k => $v) {
					$counter = 0;
					foreach ($v as $offset => $picture_detail) {
						$pictures_array[$counter][$k] = $picture_detail;
						$counter++;
					}
				}
			}

			foreach ($pictures_array as $key => $value) {
				$tempFile = $value['tmp_name'];
				$targetPath = $store_folder . $ds;
				$targetFile = $targetPath . $value['name'];
				move_uploaded_file($tempFile, $targetFile);

				$dimensions = $this->upload->getimagedimensions($targetFile);
				$exists = $this->upload->checkifsizeexists($dimensions['dimensions']);

				if (!$exists) {
					$size_id = $this->upload->createnewsize($dimensions['dimensions']);
				}
				else
				{
					$size_id = $exists['size_id'];
				}

				$image_name = $_POST['model_first_name'] . '_' . date('YnjGis');

				$upload = $this->upload_model->addimages(base_url() . $targetFile, $size_id, $image_name);

				if($upload)
				{
					$image_id = mysql_insert_id();
					$model_image = $this->m_models->model_image($_POST['modelid'], $image_id);
				}
			}
		}
	}

	//ajax functions
	function get_ajax_model($model_id)
	{
		$models = $this->m_models->getmodelbyid($model_id);

		echo json_encode($models);
	}

	function ajax_update_model($model_id, $todo = NULL)
	{
		$activation = '';
		$model_id = $this->security->decrypt_data($model_id);
		if($todo)
		{
			switch ($todo) {
				case 'activate':
					$activation = $this->m_models->activatemodel($model_id);
					$message_end = 'Activated';
					break;
				
				case 'deactivate':
					$activation = $this->m_models->deactivatemodel($model_id);
					$message_end = 'Deactivated';
					break;
				default:
					# code...
					break;
			}
		}
		else
		{
			$date = $_POST['dob'];

			$new_date = strtotime($date);
			$new_date = date('Y-m-d', $new_date);
			
			$_POST['dob'] = $new_date;
			$activation = $this->m_models->updatemodel($model_id);
			$message_end = 'Updated';
			if($activation)
			{
				redirect(base_url().'models/modelprofile/' . $this->security->encrypt_data($model_id));
			}
		}

		if ($activation) {
			$type = 'Success';
			$message = 'Model Profile Successfully ' . $message_end;
		}
		else
		{
			$type = 'Error';
			$message = 'There was error updating the record';
		}

		$data['type'] = $type;
		$data['message'] = $message;

		echo json_encode($data);
	}

	function ajax_model_counts()
	{
		$counts = $this->m_models->getmodelcount();
		echo $counts;
	}

	function ajax_model_images($model_id)
	{
		$return_data = array();
		$pictures_section = '';
		$all_pictures = '';
		$model_images = $this->m_models->getmodelimages($model_id);

		if ($model_images) {
			$pictures_section .= '<div class="carousel slide" id="carousel2">
                                <ol class="carousel-indicators">';
            $counter = 0;
            $first_five = array_slice($model_images, 0, 5);
			foreach ($first_five as $key => $value) {
				if($counter == 0){
					$pictures_section .= '<li data-slide-to = "'.$counter.'" data-target = "#carousel2" class = "active"></li>';
				}
				else
				{
					$pictures_section .= '<li data-slide-to = "'.$counter.'" data-target = "#carousel2"></li>';
				}
				$counter++;
			}
			$pictures_section .='</ol>
			<div class="carousel-inner">';

			$counter = 0;
			foreach ($first_five as $key => $value) {
				if ($counter == 0) {
					$pictures_section .= '<div class = "item active">';
				}
				else
				{
					$pictures_section .= '<div class = "item">';
				}

				$pictures_section .= '<img alt="image"  class="img-responsive carousel_image" src="'.$value['image_path'].'">
				<div class = "carousel-caption">
					<p>'.$value['description'].'</p>
				</div></div>';

				$counter++;

			}
			$pictures_section .= '
                                <a data-slide="prev" href="#carousel2" class="left carousel-control">
                                    <span class="icon-prev"></span>
                                </a>
                                <a data-slide="next" href="#carousel2" class="right carousel-control">
                                    <span class="icon-next"></span>
                                </a>
                            </div></div>';
            $first_three = array_slice($model_images, 0, 3);
            $pictures_section .= '<br/><center><div class = "row">';
            foreach ($first_three as $key => $value) {
            	$pictures_section .= '<a href = "'.$value['image_path'].'" class = "fancybox" title = "'.$value['image_name'].'">
            	<img src = "'.$value['image_path'].'" alt = "'.$value['image_name'].'"
            	</a>';
			}
            $pictures_section .= '</div></center>';

            foreach ($model_images as $key => $value) {
            	$all_pictures .= '<a href = "'.$value['image_path'].'" class = "fancybox" title = "'.$value['image_name'].'">
            	<img src = "'.$value['image_path'].'" alt = "'.$value['image_name'].'"
            	</a>';
            }
		}
		else
		{
			$pictures_section .= '<div class = "no_data">
			<center><h1>No images Here!</h1>
			<a class = "btn btn-danger btn-outline upload_caller">Scroll Down to Upload Some</a></center>
			</div>';

			$all_pictures = $pictures_section;
		}

		$return_data['pictures_section'] = $pictures_section;
		$return_data['all_pictures'] = $all_pictures;

		echo json_encode($return_data);
	}

	function ajax_edit_model_details($model_id)
	{
		$form_details = '';
		$return_data = array();
		$model_details = $this->m_models->getmodelbyid($model_id);

		foreach ($model_details as $key => $value) {
			$form_details .= '<div class="form-group"><label class="col-sm-3 control-label">First Name: </label>

		                        <div class="col-sm-9"><input type="text" class="form-control" name = "first_name" required value = "'.$value['first_name'].'"></div></div>';
			$form_details .= '<div class="form-group"><label class="col-sm-3 control-label">Last Name: </label>

		                        <div class="col-sm-9"><input type="text" class="form-control" name = "last_name" required value = "'.$value['last_name'].'"></div></div>';
			$form_details .= ' <div class="form-group" id="data_1">
	                                <label class="col-sm-3 control-label">Date of Birth: </label>
	                                <div class = "col-sm-9">
		                                <div class="input-group date">
		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control dob" name = "dob" required value = "'.date('m/d/Y', strtotime($value['dob'])).'">
		                                </div>
	                                </div>
	                            </div>';
	        $form_details .= '<div class="form-group"><label class="col-sm-3 control-label">Telephone: </label>

		                        <div class="col-sm-9"> <div class="input-group m-b"><span class="input-group-addon"><i class = "fa fa-phone"></i></span> <input  required type="text" placeholder="Telephone" class="form-control" name = "telephone" value = "'.$value['telephone'].'" required></div></div>

		                    </div>';

		    $form_details .= '<div class="form-group"><label class="col-sm-3 control-label">Email: </label>

		                        <div class="col-sm-9"> <div class="input-group m-b"><span class="input-group-addon">@</span> <input required type="email" placeholder="Email Address" class="form-control" name = "email" value = "'.$value['email'].'"></div></div>
		                    </div>';
		    $form_details .= '<div class="form-group"><label class="col-sm-3 control-label">Address: </label>

		                        <div class="col-sm-9"><textarea class="form-control" name = "address" required>'.$value['address'].'</textarea></div>
		                    </div>';
		    $form_details .= ' <div class="form-group"><label class="col-sm-3 control-label">Occupation: </label>

		                        <div class="col-sm-9"><input type="text" class="form-control" name = "occupation" required value = "'.$value['occupation'].'"></div>
		                    </div>
		                     <div class="form-group"><label class="col-sm-3 control-label">Company: </label>

		                        <div class="col-sm-9"><input type="text" class="form-control" name = "company" required value = "'.$value['company'].'"></div>
		                    </div>
		                   ';
		}

		$return_data['heading'] = "Updating: " . ucwords(strtolower($model_details[$model_id]['first_name'] . ' ' . $model_details[$model_id]['last_name']))."'s Profile";
		$return_data['form_action'] = base_url().'models/ajax_update_model/'.$this->security->encrypt_data($model_id);
		$return_data['theform'] = $form_details;

		echo json_encode($return_data);
	}
}