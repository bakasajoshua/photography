<?php
if (!defined("BASEPATH")) exit("No direct access to this script");

/**
* @author Chrispine Otaalo
*/
class Search_model extends CI_Model
{
	function __construct()
	{
		parent:: __construct();
	}

	function searchdatabase()
	{
		$parameter = $this->input->post('search');
		$data = array();
		$data_images = array();
		$return_data = array();

		$parameter = explode(' ', $parameter);
		foreach ($parameter as $key => $value) {
			$model_query = $this->db->query("SELECT * FROM  models WHERE first_name LIKE '%".$value."%' OR last_name LIKE '%".$value."%' OR dob LIKE '%".$value."%' OR telephone LIKE '%".$value."%' OR email LIKE '%".$value."%' OR address LIKE '%".$value."%' OR occupation LIKE '%".$value."%'");

			$image_query = $this->db->query("SELECT * FROM images i JOIN image_sizes s ON s.size_id = i.size_id WHERE size LIKE '%".$value."%' OR i.image_name LIKE '%".$value."%' OR i.description LIKE '%".$value."%'");

			$event_query = $this->db->query("SELECT * FROM events");

			$model_result = $model_query->result_array();
			$image_result = $image_query->result_array();
			$event_result = $event_query->result_array();

			if($model_result)
			{
				foreach ($model_result as $key => $value) {
					$model_images = $this->db->query("SELECT * FROM image_model mi JOIN images i ON mi.img_id = i.image_id WHERE mi.model_id = {$value['model_id']}");
					$result = $model_images->result_array();
					foreach ($result as $k => $v) {
						$data_images['models'][] = $v;
					}
					$data['models'][$value['model_id']] = $value;
				}
			}
			else
			{
				$data['models'] = array();
			}

			if ($image_result) {
				foreach ($image_result as $key => $value) {
					$data['images'][] = $value;
				}
			}
			else
			{
				$data['images'] = array();
			}

			if($event_result)
			{
				foreach ($event_result as $key => $value) {
					$model_images = $this->db->query("SELECT * FROM image_event mi JOIN images i ON mi.img_id = i.image_id WHERE mi.event_id = {$value['event_id']}");
					$result = $model_images->result_array();
					foreach ($result as $k => $v) {
						$data_images['events'][] = $v;
					}
					$data['events'][$value['event_id']] = $value;
				}
			}
			else
			{
				$data['events'] = array();
			}
			
		}

		array_push($return_data, $data);
		array_push($return_data, $data_images);

		echo "<pre>";print_r($return_data);die;
	}
}