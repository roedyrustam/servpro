<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $data;

   public function __construct() {

        parent::__construct();
        $this->data['theme']     = 'user';
        $this->data['module']    = 'home';
        $this->data['page']     = '';
        $this->data['base_url'] = base_url();
        $this->load->model('home_model','home');
        $this->load->model('dashboard_model','dashboard');

         $this->user_latitude=(!empty($this->session->userdata('user_latitude')))?$this->session->userdata('user_latitude'):'';
         $this->user_longitude=(!empty($this->session->userdata('user_longitude')))?$this->session->userdata('user_longitude'):'';
         $this->currency= settings('currency');
         $this->load->library('Ajax_pagination'); 
        $this->perPage = 12;        
    }

	
	public function index()
	{
		 $this->data['page'] = 'index';
	     $this->data['category']=$this->home->get_category();
	     $this->data['services']=$this->home->get_service();
	     $this->data['doctitle']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'doctor_title'")->row_array();
	     $results = $this->dashboard->get_setting_list();
       	 foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
	     }
	     $this->data['content']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'doctor_content'")->row_array();
         $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function services()
	{
		 $conditions['returnType'] = 'count'; 
		$inputs['price_range'] = $this->input->post('price_range'); 
		$inputs['sort_by'] = $this->input->post('sort_by'); 
		$inputs['common_search'] = $this->input->post('common_search'); 
		$inputs['categories'] = $this->input->post('categories'); 
		$inputs['service_latitude'] = $this->input->post('user_latitude'); 
		$inputs['service_longitude'] = $this->input->post('user_longitude'); 


        $totalRec = $this->home->get_all_service($conditions,$inputs); 
         
        // Pagination configuration 
        $config['target']      = '#dataList'; 
        $config['link_func']      = 'getService';
        $config['loading']='<img src="'.base_url().'assets/front_end/images/loader.gif" alt="" />';
        $config['base_url']    = base_url('home/ajaxPaginationData'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $this->perPage; 
         
        // Initialize pagination library 
        $this->ajax_pagination->initialize($config); 
         
        // Get records 

        $conditions = array( 
            'limit' => $this->perPage 
        );
         

         $this->data['module']    = 'services';
         $this->data['page'] = 'index';
         $this->data['service']=$this->home->get_all_service($conditions,$inputs);
	     $this->data['count']=$totalRec;
         $this->data['category']=$this->home->get_category();
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function all_services()
	{
		$conditions['returnType'] = 'count'; 

		$inputs['price_range'] = $this->input->post('price_range'); 
		$inputs['sort_by'] = $this->input->post('sort_by'); 
		$inputs['common_search'] = $this->input->post('common_search'); 
		$inputs['categories'] = $this->input->post('categories'); 
		$inputs['service_latitude'] = $this->input->post('service_latitude'); 
		$inputs['service_longitude'] = $this->input->post('service_longitude'); 


        $totalRec = $this->home->get_all_service($conditions,$inputs); 
         
        // Pagination configuration 
        $config['target']      = '#dataList'; 
        $config['link_func']      = 'getService';
        $config['loading']='<img src="'.base_url().'assets/front_end/images/loader.gif" alt="" />';
        $config['base_url']    = base_url('home/ajaxPaginationData'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $this->perPage; 
         
        // Initialize pagination library 
        $this->ajax_pagination->initialize($config); 
         
        // Get records 

        $conditions = array( 
            'limit' => $this->perPage 
        );
         $this->data['module']    = 'services';
         $this->data['page'] = 'ajax_service';
	     $this->data['service']=$this->home->get_all_service($conditions,$inputs);
	     $result['count']=$totalRec;
	     $result['service_details']=$this->load->view($this->data['theme'].'/'.$this->data['module'].'/'.$this->data['page'],$this->data,TRUE);
	     echo json_encode($result);

		

	}



	function ajaxPaginationData(){ 
        // Define offset 
        $page = $this->input->post('page'); 
        if(!$page){ 
            $offset = 0; 
        }else{ 
            $offset = $page; 
        } 
         
        // Get record count 
        $conditions['returnType'] = 'count'; 
        $totalRec = $this->home->get_all_service($conditions); 
         
        // Pagination configuration 
        $config['target']      = '#dataList'; 
        $config['link_func']      = 'getService';
        $config['loading']='<img src="'.base_url().'assets/front_end/images/loader.gif" alt="" />';
        $config['base_url']    = base_url('home/ajaxPaginationData'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $this->perPage; 
         
        // Initialize pagination library 
        $this->ajax_pagination->initialize($config); 
         
        // Get records 
        $conditions = array( 
            'start' => $offset, 
            'limit' => $this->perPage 
        ); 
         
        // Load the data list view 
         $this->data['module']    = 'services';
         $this->data['page'] = 'ajax_service';
	     $this->data['service']=$this->home->get_all_service($conditions);
	     $result['count']=$totalRec;
	     $result['service_details']=$this->load->view($this->data['theme'].'/'.$this->data['module'].'/'.$this->data['page'],$this->data,TRUE);
	     echo json_encode($result);
    } 

	public function service_preview()
  {
      if(isset($_GET['sid'])&&!empty($_GET['sid']))
      {
      	 $inputs=array();
      	 $inputs['id']=$_GET['sid'];
      	 $this->data['module']    = 'service_preview';
         $this->data['page'] = 'index';
	     $this->data['service']=$this->home->get_service_details($inputs);
	     $this->views($this->data['service']);
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
      }
      else
      {
         redirect(base_url());
      }
  }

  private function views($inputs)
  {
  	 $service_id=$inputs['id'];
  	 $user_id=rand(1,100);
  	
  	 $this->db->select('id');
	 $this->db->from('views');
	 $this->db->where('user_id',$user_id);
	 $this->db->where('service_id',$service_id);
	 $check_views = $this->db->count_all_results();

	 $this->db->select('id');
	 $this->db->from('services');
	 $this->db->where('user_id',$user_id);
	 $this->db->where('id',$service_id);
	 $check_self_gig = $this->db->count_all_results();

	 if($check_views == 0 && $check_self_gig == 0){
	   $this->db->insert('views', array('user_id'=>$user_id, 'service_id'=>$service_id));

	   $this->db->set('total_views', 'total_views+1', FALSE);
	   $this->db->where('id',$service_id);
	   $this->db->update('services');
	 }
  }

  public function get_common_search_value()
  {
  	if (isset($_GET['term'])) {
  		$search_value=$_GET['term'];
  		  $this->db->select("s.service_title,s.service_location,s.service_offered,c.category_name");
	      $this->db->from('services s');
	      $this->db->join('categories c', 'c.id = s.category', 'LEFT');
	      $this->db->where("s.status = 1");
	      $this->db->group_start();
	      $this->db->like('s.service_title', $search_value);
	      $this->db->or_like('s.service_location', $search_value);
	      $this->db->or_like('s.service_offered', $search_value);
	      $this->db->or_like('c.category_name', $search_value);
	      $this->db->group_end();
	      $result = $this->db->get()->result_array(); 
	      if (count($result) > 0) {
			foreach ($result as $row)
				$service_offered=explode(',', $row['service_offered']);
			for ($i=0; $i <count($service_offered) ; $i++) 
			{ 
				$arr_result[] = ucfirst($service_offered[$i]);
			}
			$arr_result[] = ucfirst($row['service_title']);
		    $arr_result[] = ucfirst($row['category_name']);

		    echo json_encode($arr_result);
			}
	  }

  }
	
	public function user_dashboard()
	{
		 $this->data['page'] = 'user_dashboard';
	     $this->data['category']=$this->home->get_category();
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}


	public function add_service()
	{
		 $this->data['page'] = 'add_service';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function user_bookings()
	{
		 $this->data['page'] = 'user_bookings';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function user_notifications()
	{
		 $this->data['page'] = 'user_notifications';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function user_favourites()
	{
		 $this->data['page'] = 'user_favourites';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function user_settings()
	{
		 $this->data['page'] = 'user_settings';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function user_reviews()
	{
		 $this->data['page'] = 'user_reviews';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function user_chats()
	{
		 $this->data['page'] = 'user_chats';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function prof_services()
	{
		 $this->data['page'] = 'prof_services';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}

	public function prof_service_detail()
	{
		 $this->data['page'] = 'prof_service_detail';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}


	public function prof_packages()
	{
		 $this->data['page'] = 'prof_packages';
	     $this->load->vars($this->data);
		 $this->load->view($this->data['theme'].'/template');
	}	

	public function set_location()
	{
		$details= array('user_address' =>$this->input->post('address'), 
						'user_latitude' =>$this->input->post('latitude'),
						'user_longitude' =>$this->input->post('longitude'));
		$this->session->set_userdata($details);
	}

  	public function ajaxSearch() {
	    if ($this->input->post('title')) {
	        $stmt =  $this->home->fetch_data($this->input->post('title'));
	    }
	    echo $stmt;
    }
    
}
