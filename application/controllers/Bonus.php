<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		//$this->load->model('Ion_auth_model');
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language','form'));
		$this->data['uid'] =  $this->session->userdata('user_id');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}
	
	
	public function calculateAssistantBonus()
	{
		$queryActiveUsers = $this->db->get_where('users',array('active' => '1'));
		$getActiveUsers = $queryActiveUsers->result();
		
		foreach ($getActiveUsers as $getActiveUser) {
			
			$plan_id = $getActiveUser->plan;
			$user_id = $getActiveUser->id;
			if($plan_id != '0'){
				$getPlanDetail = $this->db->get_where('plans',array('id' => $plan_id));
			    $getPlan =  $getPlanDetail->row();
			$getPlanValue = $getPlan->assistant_bonus;
			$this->db->insert('bonus',array('user_id'=>$user_id,'assistent_bonus' => $getPlanValue));
		}
		}


	}
}