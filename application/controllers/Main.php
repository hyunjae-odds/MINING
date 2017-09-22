<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->view('/user/login');
	}
}