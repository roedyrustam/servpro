<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	 public function __construct() {
        parent::__construct();
        if(empty($this->session->userdata('user_id')))
				{
					redirect(base_url());
				}
        $this->load->model('home_model','home');
        $this->load->model('categories_model','category');
        $this->load->model('language_model','language');
        $this->load->model('dashboard_model','dashboard');
        $this->load->model('service_model','service');
        $this->data['view'] = 'user';
        $this->data['base_url'] = base_url();

		$this->load->helper('custom_language');
		$this->load->helper('currency_helper');
		$lang = $this->session->userdata('lang');
		$this->data['language_content'] = get_languages($lang);
		$this->data['default_language'] = default_languages($lang);
        $this->latitude = $this->session->userdata('latitude');
        $this->longitude =  $this->session->userdata('longitude');
        $user_id = $this->session->userdata('user_id');
        $this->data['user_id'] = $user_id;
		$this->load->helper('subscription_helper');
		 $this->data['subscription_details']=array();
        $this->data['subscription_details'] = get_subscription_details(md5($user_id));
		$this->data['language'] = $this->language->active_language();
		$this->data['category'] = $this->category->show_category();
		
    }


	public function index()
	{
		$this->data['page'] = 'home';
		$this->data['model'] = 'home';
		$this->data['banner'] = $this->dashboard->banner_system_settings("banner");
		$inputs['user_id'] = $this->session->userdata('user_id');
		$getloc = json_decode(file_get_contents("https://ipinfo.io?token=03bd6e32f118ce"));
        $coordinates = explode(",", $getloc->loc); 
        $lat = $coordinates[0]; 
        $long = $coordinates[1];
        if(!empty($this->latitude)) {
        	$inputs['latitude'] = $this->latitude;
        }
        else {
        	 $inputs['latitude'] = $lat;
        }
        if(!empty($this->longitude)) {
        	$inputs['longitude'] = $this->longitude;
        }
        else {
        	 $inputs['longitude'] = $long;
        }
        $this->data['provider_list'] = $this->home->get_services($inputs);
		$this->data['request_list'] = $this->home->get_request($inputs);
		$this->data['request_details'] = $this->home->get_requestdetails();
		$this->data['total_services'] = $this->home->get_total_services();
		$this->data['total_users'] = $this->home->get_total_users();
		$this->data['doctitle']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'doctor_title'")->result_array();
	    $this->data['doccontent']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'doctor_content'")->result_array();
	    $this->data['defaultcurrency']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
	    $results = $this->dashboard->get_setting_list();
       	 foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
	    }
		$this->load->vars($this->data);
		$this->load->view('template');
	}

	public function search_service($value='')
	{

		  $search = str_replace(" ","-",$this->input->get('term'));
		  $query = $this->db->query("SELECT * FROM  request_details WHERE  title LIKE '%$search%' AND r_id NOT IN  (SELECT request_id FROM request_accept_details)");
		  $result = $query->result_array();
		  if(!empty($result)){

		    $final_array = array();
		    foreach ($result as $row) {
			  $label = str_replace("-"," ",$row['title']); //build an array
			  $id = md5($row['r_id']);  //build an array
			  $final_array[] = array('label'=> $label,'value'=>$label,'id'=>$id);
			}
		}else{

			  $final_array = array();
			  $final_array[] = "No Results Found";
			}
			echo json_encode($final_array);

	}
	public function updatemulticurrency(){
		$code = $this->input->post('code');
		$this->session->unset_userdata('usercurrency_code');
		$this->session->set_userdata('usercurrency_code',$code);
		echo TRUE;
	}

	public function search_request_details()
	{
		$this->data['page'] = 'search_request';
		$this->data['model'] = 'home';
		$inputs['user_id'] = $this->session->userdata('user_id');;
    	$inputs['search_title'] = $this->input->post('search');
		$this->data['result'] = $this->home->get_search_request($inputs);
		$this->load->vars($this->data);
		$this->load->view('template');
	}

}
