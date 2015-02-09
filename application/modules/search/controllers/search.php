<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('search_model');
	}

	function index()
	{
		$results = $this->search_model->searchdatabase();
	}
}