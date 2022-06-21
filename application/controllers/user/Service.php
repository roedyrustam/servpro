<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Service extends CI_Controller {

    public function __construct() {

        parent::__construct();
     		$this->load->helper('push_notifications');
	      $this->data['view'] = 'user';
        $this->data['base_url'] = base_url();

        $this->session->keep_flashdata('error_message');
        $this->session->keep_flashdata('success_message');

			  $this->load->helper('custom_language');
			  $lang = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
			  $this->data['language_content'] = get_languages($lang);
        $this->web_validation_array = $this->data['language_content']['language'];

        $this->load->model('service_model','service');
        $this->load->model('request_model','request');
        $this->latitude = !empty($this->session->userdata('user_latitude'))?$this->session->userdata('user_latitude'):'3.021998';
        $this->longitude =  !empty($this->session->userdata('user_longitude'))?$this->session->userdata('user_longitude'):'101.7055411';$user_id = $this->session->userdata('user_id');
        $this->data['user_id'] = $user_id;
				$this->load->helper('subscription_helper');
        $this->data['subscription_details'] = get_subscription_details(md5($user_id));
        $this->load->model('categories_model','category');
        $this->load->model('language_model','language');
        $this->data['language'] = $this->language->active_language();
        $this->data['category'] = $this->category->show_category(); 

        /*if(!$this->session->userdata('user_id'))
		{
			redirect(base_url());
		}*/
    }

	public function index()
	{
  		$this->data['page'] = 'service';
  		$this->data['model'] = 'service';

      if($this->input->post('pid')){ $inputs['pid'] = $this->input->post('pid'); }
   		$inputs['user_id'] = $user_id = $this->session->userdata('user_id');
      $inputs['page'] = 1;
    	$inputs['latitude'] = $this->latitude;
  	  $inputs['longitude'] = $this->longitude; 

  		$this->data['services'] = $this->service->get_services($inputs);
      $this->data['subscription_details'] = get_subscription_details(md5($user_id));

  		$this->load->vars($this->data);
  		$this->load->view('template');
	}

  public function service_categories($pid = ""){
    
      $this->data['page'] = 'service_categories';
      $this->data['model'] = 'service';

      $this->session->set_userdata('service_cat_search', $pid);
      $category = $this->category->select_provide_bycategory($pid);
      $inputs['pid'] = isset($category[0])?$category[0]["categories"]:"";
      $inputs['user_id'] = $user_id = $this->session->userdata('user_id');
      $inputs['page'] = 1;
      $inputs['latitude'] = $this->latitude;
      $inputs['longitude'] = $this->longitude; 

      $this->data['services'] = $this->service->get_services($inputs);
      $this->data['subscription_details'] = get_subscription_details(md5($user_id));
  
      $this->load->vars($this->data);
      $this->load->view('template');
  }

  function load_my_service_categories(){
      $pid = $this->session->userdata('service_cat_search');
      $category = $this->category->select_provide_bycategory($pid);
      $inputs['pid'] = isset($category[0])?$category[0]["categories"]:"";
      $inputs['user_id'] = $user_id = $this->session->userdata('user_id');
      $inputs['page'] = $this->input->post('nextpage');
      $inputs['latitude'] = $this->latitude;
      $inputs['longitude'] = $this->longitude;
      
      $services = $this->service->get_services($inputs);
      echo json_encode($services);
      die();
  }

		public function create_service()
	{
   
		if($this->input->post()){
			$params = $this->input->post();
			$result = $this->service->create_service($params);
			if($result == 1){
        /*
          $to_user_id = 0;
          $title = $params['title'];
          $user_id = $this->session->userdata('user_id');
          $name  = $this->service->username($user_id);
          $username = $name['username'];
          $message = '<b>'.$username.'</b> created new service';
          $notification_type = 'Create Service';
          $this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
        */

				$this->session->set_flashdata('success_message',$this->web_validation_array['lg12_new_service_has']);
			}
			echo $result;
			die();
		}
	}

	public function load_service()
	{

 		  $inputs['user_id'] = $this->session->userdata('user_id');
      $inputs['page'] = $this->input->post('nextpage');
  	  $inputs['latitude'] = $this->latitude;
      $inputs['longitude'] = $this->longitude;
  		$services = $this->service->get_services($inputs);
  		echo json_encode($services);
  		die();
	}

  	public function service_search_list()
	{

 		  $inputs['user_id'] = $this->session->userdata('user_id');
      $inputs['page'] = ($this->input->post('nextpage')>0)?$this->input->post('nextpage'):1;
      $inputs['search_title'] = $this->input->post('search_title');
      $inputs['category'] = $this->input->post('category');
      $inputs['subcategory'] = $this->input->post('subcategory');
      $inputs['request_date'] = !empty($this->input->post('request_date'))?$this->input->post('request_date'):'';
      if(!empty($inputs['request_date'])){
        $inputs['request_date'] = date('Y-m-d',strtotime($inputs['request_date']));
      }
      $inputs['location'] = $this->input->post('location');
      $inputs['latitude'] =!empty($this->input->post('latitude'))?$this->input->post('latitude'):$this->latitude;
      $inputs['longitude'] =!empty($this->input->post('longitude'))?$this->input->post('longitude'):$this->longitude;
      $services = $this->service->get_services($inputs);
      echo json_encode($services);
  		die();
	}

    public function my_services()
  {
      $this->data['page'] = 'my_services';
      $this->data['model'] = 'service';
      $inputs['user_id'] = $this->session->userdata('user_id');
      $inputs['page'] = 1;
      $this->data['services'] = $this->service->my_services($inputs);
      $this->load->vars($this->data);
      $this->load->view('template');

  }
    public function load_myservice()
  {

    $inputs['user_id'] = $this->session->userdata('user_id');
    $inputs['page'] = $this->input->post('nextpage');
    $services = $this->service->my_services($inputs);
    echo json_encode($services);
    die();
  }


	public function add_service()
	{

    if($this->input->post()){
      $service = $this->input->post();


      $service['title'] = $this->input->post('title');
      $service['category'] = $this->input->post('category');
      // $service['subcategory'] = $this->input->post('subcategory');
      $service['description'] = $this->input->post('description');
      $service['location'] = $this->input->post('location');
      $service['latitude'] = $this->input->post('latitude');
      $service['longitude'] = $this->input->post('longitude');
      $service['start_date'] = $this->input->post('start_date');
      $service['end_date'] = $this->input->post('end_date');
      $service['countryCode'] = $this->input->post('countryCode');
      $service['countryCode']  = $this->input->post('countryCode');
      $service['contact_number']  = $this->input->post('contact_number');
      $service['availability'] = $this->input->post('availability');
      $service['service_image'] = (!empty($this->input->post('service_image')))?"uploads/service_image/" . $this->input->post('service_image'):'';
     
      $this->service->create_service($service);
      $this->session->set_flashdata('success_message',$this->web_validation_array['lg12_new_service_add']);
      redirect(base_url(). "my-services");
      die();
    }
    $this->data['page'] = 'add-service';
        $this->data['model'] = 'service';
    $this->data['country_list']=$this->db->where('status',1)->order_by('country_name',"ASC")->get('country_table')->result_array();
    $this->load->vars($this->data);
		$this->load->view('template');
	}

  public function edit_service($p_id)
	{
		$this->data['page'] = 'edit-service';
		$this->data['model'] = 'service';
    $this->data['service_details'] = $this->service->get_service_details($p_id);
    $this->data['country_list']=$this->db->where('status',1)->order_by('country_name',"ASC")->get('country_table')->result_array();
		$this->load->vars($this->data);
		$this->load->view('template');
	}

  public function update_service()
	{
        if($this->input->post()){
			$params = $this->input->post();
            $token = md5($params["p_id"]);
			$result = $this->service->update_service($params);
			if($result == 1){
        /*
          $to_user_id = 0;
          $title = $params['title'];
          $user_id = $this->session->userdata('user_id');
          $name  = $this->service->username($user_id);
          $username = $name['username'];
          $message = '<b>'.$username.'</b> updated his service';
          $notification_type = 'Update Service';
          $this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
        */
				$this->session->set_flashdata('success_message',$this->web_validation_array['lg12_your_service_ha']);
                redirect(base_url(). "my-services");
			}
      elseif($result == 2){
				$this->session->set_flashdata('error_message',$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'].', '.$this->web_validation_array['lg12_please_try_agai']);
                redirect(base_url(). "edit-service/".$token);
			}
			die();
		}
	}

	public function service_view($r_id)
	{
    //if($this->session->userdata('user_id')) {
      $user_id = $this->session->userdata('user_id');
  		$this->data['page'] = 'service-view';
  		$this->data['model'] = 'service';
      $this->data['service_details'] = $this->service->get_service_details($r_id);
      $this->data['booked_sevice'] = $this->service->get_booked_service($r_id, $user_id);
      $this->data['subscription_details'] = get_subscription_details(md5($user_id));
  		$this->load->vars($this->data);
  		$this->load->view('template');
    /*} else {
    	redirect(base_url()."login");
	}*/
  }

	public function history()
	{
    if($this->session->userdata('user_id'))
		{
  		$this->data['page'] = 'history';
  		$this->data['model'] = 'service';
      $sinputs['user_id'] = $inputs['user_id'] = $this->session->userdata('user_id');
      $sinputs['status'] = array(2,3);
      $sinputs['page'] = 1;
      $inputs['status'] = array(1);
      $inputs['page'] = 1;
  		$this->data['history'] = $this->service->get_history($sinputs);
  		$this->data['pending'] = $this->service->get_pending_history($inputs);
      $this->data['defaultcurrency']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
  		$this->load->vars($this->data);
  		$this->load->view('template');
    }else {
      redirect(base_url());
    }
	}

  public function load_complete_history()
  {
  $inputs['user_id'] = $this->session->userdata('user_id');;
  $inputs['page'] = $this->input->post('nextpage');
  $inputs['status'] = 2;
  $requests = $this->service->get_history($inputs);
  echo json_encode($requests);
  die();
  }

  public function load_pending_history()
  {
  $inputs['user_id'] = $this->session->userdata('user_id');;
  $inputs['page'] = $this->input->post('nextpage');
  $inputs['status'] = 1;
  $requests = $this->service->get_history($inputs);
  echo json_encode($requests);
  die();
  }

  public function history_view($r_id)
	{
    if($this->session->userdata('user_id'))
		{
  		$this->data['page'] = 'history-view';
  		$this->data['model'] = 'service';
      $this->data['request_details'] = $this->service->get_history_details($r_id);
      $this->data['defaultcurrency']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
  		$this->load->vars($this->data);
  		$this->load->view('template');
    }
		else {
			redirect(base_url());
		}
	}

  public function complete_request()
	{
		$req_id = $this->input->post('req_id');
    $result = $this->service->change_request_status($req_id, 2);
    if($result){
      $request_details = $this->service->get_history_details($req_id);
            /* Notification starts */
			      $to_user_id = $request_details['acceptor_id'];
						$title = $request_details['title'];
						$user_id = $this->session->userdata('user_id');
						$name  = $this->request->username($user_id);
            $username = $name['username'];
						$notify_message = $username.' completed your accepted request';
            $notification_type = 'Complete Request Accept';
						$this->notifications($notification_type,$title,$notify_message,$to_user_id,$user_id);
            /* Notification ends */
			$message=$this->web_validation_array['lg12_request_complet'];
		  $this->session->set_flashdata('success_message',$message);
    }
    else{
			$message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
		  $this->session->set_flashdata('error_message',$message);
    }
    echo 1;
	}

  public function decline_request()
	{
		$req_id = $this->input->post('req_id');
    $result = $this->service->change_request_status($req_id, 3);
    if($result){
      $request_details = $this->service->get_history_details($req_id);
            /* Notification starts */
			      $to_user_id = $request_details['acceptor_id'];
						$title = $request_details['title'];
						$user_id = $this->session->userdata('user_id');
						$name  = $this->request->username($user_id);
						$username = $name['username'];
						$notify_message = '<b>'.$username.'</b> declined your accepted request';
            $notification_type = 'Decline Request Accept';
						$this->notifications($notification_type,$title,$notify_message,$to_user_id,$user_id);
            /* Notification ends */
			$message=$this->web_validation_array['lg12_request_decline'];
		  $this->session->set_flashdata('success_message',$message);
    }
    else{
			$message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
		  $this->session->set_flashdata('error_message',$message);
    }
    echo 1;
	}

  public function delete_service()
	{
		$p_id = $this->input->post('p_id');
  		$result = $this->service->delete_service($p_id);
      if($result){
  			$message=$this->web_validation_array['lg12_your_service_ha1'];
  		  $this->session->set_flashdata('success_message',$message);
        echo 1;
      }
      else{
  			$message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
  		  $this->session->set_flashdata('error_message',$message);
        echo 2;
      }
  }

   public function notifications($notification_type,$title,$message,$to_user_id = 0,$login_id)
    {
      $ios_target = array();
    $android_target = array();
      $body =array(
            'notification_type'=>$notification_type,
            'title'=>   $title,
            'message'=> $message
            );


      $target = $this->service->get_deviceids($to_user_id,$login_id);
      $deviceid = 0;

        $ios_target = $target['ios'];
        if(count($ios_target) > 0){
          $ios_target = array_map('current', $ios_target);
          $deviceid =1;
        }
        $android_target = $target['android'];
        if(count($android_target) > 0){
          $android_target = array_map('current', $android_target);
          $deviceid = 1;
        }

    $data['body'] = $body;
    // Android Notifications
    if(count($android_target) > 0){
      $android_result_array = sendFCMMessage($data,$android_target);
    }
    // iOS Notifications
    if(count($ios_target) > 0){
      $ios_result_array = sendFCMiOSMessage($data,$ios_target);
    }
    }


    public function get_category()
    {
      $this->db->where('status',1);
            $query=$this->db->get('categories');
            $result= $query->result();
              $data=array();
          foreach($result as $r)
          {
            $data['value']=$r->id;
            $data['label']=$r->category_name;
            $json[]=$data;
            
            
          }
        echo json_encode($json);
        }

        public function get_subcategory()
    {
      if($_POST['id'])
      {
        $this->db->where('status',1);
        $this->db->where_in('category',$_POST['id']);
            $query=$this->db->get('subcategories');
            $result= $query->result();
              $data=array();
          foreach($result as $r)
          {
            $data['value']=$r->id;
            $data['label']=$r->subcategory_name;
            $json[]=$data;
            
            
          }
      }
      else
      {
            $data['value']='';
            $data['label']='';
            $json[]=$data;
      }
      
        echo json_encode($json);
      }


           public function get_subcategorys()
    {
      $this->db->where('status',1);
      $this->db->where_in('category',explode(',',$_POST['id']));
            $query=$this->db->get('subcategories');
            $result= $query->result();
              $data=array();
          foreach($result as $r)
          {
            $data['value']=$r->id;
            $data['label']=$r->subcategory_name;
            $json[]=$data;
            
            
          }
        echo json_encode($json);
        }



        public function book_service()
        {
          if(!empty($this->input->post('availability_time'))) {
              $availability_time=explode(',', $this->input->post('availability_time'));
          $provider_id=$this->input->post('provider_id');
          $user_id=$this->input->post('user_id');
          $latitude=$this->input->post('latitude');
          $longitude=$this->input->post('longitude');

          $data['date']=date('Y-m-d H:i:s');
          $data['service_date']=date('Y-m-d',strtotime($availability_time[0]));
          $service_time=explode('-', $availability_time[1]);
          $data['from_time']=date('H:i:s',strtotime($service_time[0]));
          $data['to_time']=date('H:i:s',strtotime($service_time[1]));
          $data['notes']=$this->input->post('notes');
          $data['provider_id']=$provider_id;
          $data['user_id']=$user_id;
          $data['latitude']=$latitude;
          $data['longitude']=$longitude;
          $data['service_status']=1;
          $data['notification_status']=1;
          $data['status']=1;

          $this->db->where('service_date', $data['service_date']);
          $this->db->where('provider_id', $provider_id);
          $this->db->where('user_id', $user_id);
          $count = $this->db->count_all_results('book_service');
          if($count == 0){
            if($this->db->insert('book_service',$data))
            {
              $to_user_id = 0;
              $details=$this->service->provider($provider_id);
              $title = $details['title'];
              $to_user_id = $details['user_id'];
              $user_id = $this->session->userdata('user_id');
              $name  = $this->service->username($user_id);
              $username = $name['username'];
              $message = $username.'added new Booking';
              $notification_type = 'Create Booking';
              //$this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
              $this->session->set_flashdata('success_message','Booked successfully');
              redirect('service-view/'.md5($provider_id));
            }
            else
            {
                 $this->session->set_flashdata('error_message','Booking failed');
                 redirect('service-view/'.md5($provider_id));
            }

        }
        else
        {
            $this->session->set_flashdata('error_message','Already booked');
               redirect('service-view/'.md5($provider_id));
          
        }
          }
          else {
            $provider_id=$this->input->post('provider_id');
              $this->session->set_flashdata('error_message','Booking Expired');
                 redirect('service-view/'.md5($provider_id));
          }
          
    }

    public function view_rating_reviews()
    {
      $p_id=$this->input->post('p_id');
      $result=$this->db->query("SELECT r.rating,r.review,r.created,u.full_name,u.profile_img FROM rating_review AS r 
                                LEFT JOIN users AS u ON u.user_id=r.user_id
                                WHERE r.p_id='".$p_id."'")->result_array();
      if(!empty($result))
      {
        foreach ($result as $rows) 
        {  
          $prof_img=(!empty($rows['profile_img']))?$rows['profile_img']:'assets/img/user.jpg';
          $html='<article class="row">
                          <div class="col-md-3 col-sm-3 hidden-xs">
                            <figure class="">
                              <img class="img-responsive img-circle" src="'.base_url().$prof_img.'" />
                              <figcaption class="text-center mt-2">'.ucfirst($rows['full_name']).'</figcaption>
                            </figure>
                          </div>
                          <div class="col-md-9 col-sm-9">
                            <div class="review-blk arrow left">
                              <div class="panel-body">
                                <div class="comment-post">
                                    <div class="row">
                                        <div class="col-12">
                                                
                                                   <div class="comment-user"><i class="fa fa-user"></i> '.ucfirst($rows['full_name']).'</div>
                                                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="far fa-clock"></i> '.date('M d, Y',strtotime($rows['created'])).'</time>
                                                    <p class="review-color-style mb-1">';
                                                      
                                                     for ($i=0; $i <5 ; $i++) { 
                                                      if($i < $rows['rating']){
                                                      $html.='<span><i class="fa fa-star" aria-hidden="true"></i></span>';    
                                                      }else{
                                                        $html.='<span><i class="fa fa-star-o" aria-hidden="true"></i></span>';
                                                      }
                                                    }
                                                    $html.='</p>
                                            
                                                    <p class="review-notes mb-0">
                                                      '.$rows['review'].'
                                                    </p>
                                            </div>
                                            
                                        </div>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                        </article>';

                        echo $html;
                      }
          }
          else
          {
            $html='<article class="row">
                  <div class="col-md-12 col-sm-12 hidden-xs text-center">
                  <span> No Reviews</span>
                  </div>
                  </article>';

                  echo $html;
          }

          
    }

}
