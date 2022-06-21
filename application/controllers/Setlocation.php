<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setlocation extends CI_Controller {

	public function index()
	{
		if($this->input->post()){
			$this->session->set_userdata('user_address',$this->input->post('address'));
			$this->session->set_userdata('user_latitude',$this->input->post('latitude'));
			$this->session->set_userdata('user_longitude',$this->input->post('longitude'));
		}
	}
	public function language()
	{
		if($this->input->post('lang')){
			$lang = $this->input->post('lang');
			$this->session->set_userdata('lang',$lang);
			echo "1";
		}else{
			echo "0";
		}
		die();
	}
}
